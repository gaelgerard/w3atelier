<?php
/**
 * Plugin Name: Adaptateur d'enregistrement CF7 Submissions
 * Description: Enregistre manuellement des données de formulaire dans la structure Codexpert CF7 Submissions.
 */

if ( ! defined( 'ABSPATH' ) ) exit;

function custom_save_to_cf7_submissions( $data_params ) {
    // 1. Vérifier que le nouveau plugin est actif
    if ( ! class_exists( '\Codexpert\CF7_Submissions\Database' ) ) {
        return false;
    }

    $db = new \Codexpert\CF7_Submissions\Database();

    // Extraire les variables passées en argument (ou les définir globalement)
    $subject    = $data_params['subject']    ?? 'Sans objet';
    $from_name  = $data_params['from_name']  ?? 'Inconnu';
    $from_email = $data_params['from_email'] ?? '';
    $from_phone = $data_params['from_phone']      ?? '';
    $message_html = $data_params['message_html']  ?? '';
    $source     = $data_params['source']     ?? 'Direct';

    // 2. Insertion dans la table principale 'submissions'
    // Note : Le plugin utilise 'time' au format Unix (U)
    $submission_id = $db->insert( 'submissions', [
        'form_id'   => 412, 
        'post_id'   => 0,
        'user_id'   => get_current_user_id(),
        'ip'        => $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1',
        'fields'    => 7, 
        'files'     => 0,
        'time'      => current_time( 'U' ),
        'seen'      => 0 // 0 = non lu, 1 = lu
    ] );

    if ( ! $submission_id ) return false;

    // 3. Préparation des données pour la table 'submission_data'
    $message_data = [
        'subject'    => $subject,
        'from_name'  => $from_name,
        'from_email' => $from_email,
        'phone'      => $from_phone,
        'message'    => $message_html,
        'RGPD'       => 'Accepte les conditions et la politique de confidentialité',
        'source'     => $source,
    ];

    // 4. Insertion de chaque champ individuellement
    foreach ( $message_data as $key => $value ) {
        $db->insert( 'submission_data', [
            'submission_id' => $submission_id,
            'field'         => $key,
            'value'         => $value
        ] );
    }

    return $submission_id;
}

// On utilise un hook WordPress pour les headers afin d'éviter le "headers already sent"
add_action('init', function() {
    // Add this at the top of the function or file logic
    if (defined('DOING_CRON') && DOING_CRON) {
        return;
    }
    
    $origin = $_SERVER['HTTP_ORIGIN'] ?? '';
    $allowed_origins = [
        'https://www.gaelgerard.com',
        'https://gaelgerard.com',
        'https://votre-projet-vercel.vercel.app'
    ];

    if (in_array($origin, $allowed_origins)) {
        header("Access-Control-Allow-Origin: " . $origin);
        header("Access-Control-Allow-Methods: POST, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type, X-GGCOM-KEY");
        header("Access-Control-Allow-Credentials: true");
    }

    if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
        status_header(200);
        exit;
    }
});

add_action('rest_api_init', function () {
    register_rest_route('ggcom/v1', '/form', array(
        'methods'             => 'POST',
        'callback'            => 'handle_ggcom_react_form',
        'permission_callback' => function (WP_REST_Request $request) {
            // Récupération sécurisée du header via l'objet Request de WP
            $client_key = $request->get_header('X-GGCOM-KEY');
            
            // Correction de la syntaxe env() avec des guillemets
            $server_key = REACT_FORM_API_KEY;

            // Log de debug (uniquement si WP_DEBUG est à true dans .env)
            if (defined('WP_DEBUG') && WP_DEBUG) {
                if ($client_key !== $server_key) {
                    error_log("Auth Failed - Reçu: '$client_key' | Attendu: '$server_key'");
                }
            }

            return ( !empty($server_key) && $client_key === $server_key );
        },
    ));
});

function handle_ggcom_react_form(WP_REST_Request $request) {
    $params = $request->get_json_params();

    // Honeypot
    if (!empty($params['fax_number'])) {
        return new WP_REST_Response(array('status' => 'success', 'message' => 'Bot filtered'), 200);
    }

    // Vérification de l'existence de la fonction de traitement
    if (function_exists('ggcom_react_form_save_and_notify')) {
        $result = ggcom_react_form_save_and_notify($params);
        return new WP_REST_Response($result, 200);
    }

    return new WP_Error('error', 'Function ggcom_react_form_save_and_notify not found', array('status' => 500));
}

//Enregistrement des formulaires de contact depuis le site www.gaelgerard.com
if ( !function_exists('ggcom_react_form_save_and_notify')) {
	function ggcom_react_form_save_and_notify ( $dataForm ) {
		$from_name = $dataForm['from_name'] ?? '';
        $from_email = $dataForm['from_email'] ?? '';
        $from_phone = $dataForm['from_phone'] ?? '';
        $to_name = $dataForm['to_name'] ?? '';
        $source = $dataForm['source'] ?? '';
        $message_html = $dataForm['message_html'] ?? '';
        $subject = substr($message_html,0,50);
        

       
		$recipient = '';
        $recipient = 'gael.gerard@free.fr';
        $subject = 'Message sur le site : '.$subject;
		$body = '<html>';
		$body .= '<head>';
		$body .= '<title>Message depuis le site</title>';
		$body .= '</head>';
		$body .= '<body>';
        $body .= 'Message reçu de '.$from_name;
        $body .= '<br>Source : '.$source;
        $body .= '<br>Adresse email : '.$from_email;
        $body .= '<br>Téléphone : '.$from_phone;
        $body .= '<br>Message : '.$message_html;
        $body .= '<br>RGPD : Accepte les conditions et la politique de confidentialité';
		$body .= '</body>';
		$body .= '</html>';
		
        $headers = array(
            'From: "Contact ggcom" <no-reply@dev.gaelgerard.com>',
            'Content-Type: text/html; charset=UTF-8',
            'Reply-To: '.$from_email.'',
        );
        $attachments = '';
        custom_save_to_cf7_submissions( $dataForm );
        if (wp_mail( $recipient, $subject, $body, $headers )) {
            $response = array(
                'status' => 'success',
                'message' => 'Contact and message saved successfully',
                'data' => array(
                    'message' => $message_data,
                ),
            );
        } else {
            $response = array(
                'status' => 'error',
                'message' => 'Failed to save contact or message',
            );
        }
		return $response;
	}
}
