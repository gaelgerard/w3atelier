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
    $user_agent = $data_params['user_agent'] ?? '';
    $sender_ip  = $data_params['sender_ip']  ?? '';
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
        'user_agent' => $user_agent,
        'sender_ip'  => $sender_ip

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
        $subject = $dataForm['subject'] ?? '';
        $sender_ip = $dataForm['sender_ip'] ?? 'Non renseignée';
        $user_agent = $dataForm['user_agent'] ?? 'Inconnu';

       
		$recipient = '';
        $recipient = 'gael.gerard@free.fr';
        $subject_headers = 'Message sur le site : '.$subject;
		$body = '<html>';
		$body .= '<head>';
		$body .= '<title>Message depuis le site</title>';
		$body .= '</head>';
		$body .= '<body>';
        $body .= 'Message reçu de '.$from_name;
        $body .= '<br>Source : '.$source;
        $body .= '<br>Support '.$user_agent;
        $body .= '<br>Adresse IP : '.$sender_ip;
        $body .= '<br>Adresse email : '.$from_email;
        $body .= '<br>Téléphone : '.$from_phone;
        $body .= '<br>Sujet : '.$subject;
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
        if (wp_mail( $recipient, $subject_headers, $body, $headers )) {
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

/**
 * API REST - Envoi des résultats du test de visibilité
 *
 * Endpoint : POST /wp-json/ggcom/v1/visibility-result
 * Authentification : X-GGCOM-KEY
 */

add_action('rest_api_init', function () {
    register_rest_route('ggcom/v1', '/visibility-result', array(
        'methods'             => 'POST',
        'callback'            => 'handle_ggcom_visibility_result',
        'permission_callback' => function (WP_REST_Request $request) {

            $client_key = $request->get_header('X-GGCOM-KEY');
            $server_key = defined('REACT_FORM_API_KEY')
                ? REACT_FORM_API_KEY
                : '';

            return (
                !empty($server_key)
                && !empty($client_key)
                && hash_equals($server_key, $client_key)
            );
        },
    ));
});


/**
 * GGCOM - Gestion des emails du test de visibilité
 *
 * Endpoint :
 * POST /wp-json/ggcom/v1/visibility-result
 *
 * Authentification :
 * Header X-GGCOM-KEY
 *
 * Historique :
 * Table wp_ggcom_visibility_emails
 */


/* =====================================================
 * 1. CREATION AUTOMATIQUE DE LA TABLE
 * ===================================================== */

add_action('init', 'ggcom_create_visibility_emails_table');

function ggcom_create_visibility_emails_table() {

    $db_version = '1.0';
    
    if (get_option('ggcom_visibility_emails_db_version') === $db_version) {
        return;
    }

    global $wpdb;

    require_once ABSPATH . 'wp-admin/includes/upgrade.php';

    $table_name = $wpdb->prefix . 'ggcom_visibility_emails';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
        token varchar(191) NOT NULL,
        email varchar(190) NOT NULL,
        website varchar(190) NOT NULL,
        score smallint(5) unsigned DEFAULT NULL,
        status varchar(20) NOT NULL DEFAULT 'pending',
        sent_at datetime DEFAULT NULL,
        error_message text DEFAULT NULL,
        created_at datetime NOT NULL,
        updated_at datetime NOT NULL,
        PRIMARY KEY  (id),
        UNIQUE KEY token (token),
        KEY status (status)
    ) $charset_collate;";

    dbDelta($sql);

    update_option('ggcom_visibility_emails_db_version', $db_version);
}


/* =====================================================
 * 2. ENREGISTREMENT DE LA ROUTE REST
 * ===================================================== */

add_action('rest_api_init', function () {

    register_rest_route('ggcom/v1', '/visibility-result', array(
        'methods'  => 'POST',
        'callback' => 'handle_ggcom_visibility_result',

        'permission_callback' => function (WP_REST_Request $request) {

            $client_key = $request->get_header('X-GGCOM-KEY');

            $server_key = defined('REACT_FORM_API_KEY')
                ? REACT_FORM_API_KEY
                : '';

            return (
                !empty($server_key)
                && !empty($client_key)
                && hash_equals($server_key, $client_key)
            );
        },
    ));

});


/* =====================================================
 * 3. FONCTION DE TRAITEMENT
 * ===================================================== */

function handle_ggcom_visibility_result(WP_REST_Request $request) {

    global $wpdb;

    $table = $wpdb->prefix . 'ggcom_visibility_emails';

    $params = $request->get_json_params();

    if (!is_array($params)) {
        return new WP_Error(
            'invalid_payload',
            'Données JSON invalides.',
            array('status' => 400)
        );
    }

    // Récupération des données
    $token = isset($params['token'])
        ? sanitize_text_field($params['token'])
        : '';

    $testedUrl = isset($params['testedUrl'])
        ? sanitize_text_field($params['testedUrl'])
        : '';

    $email = isset($params['email'])
        ? sanitize_email($params['email'])
        : '';

    $score = isset($params['score']) && $params['score'] !== null
        ? intval($params['score'])
        : null;


    // Validation

    if (empty($token) || strlen($token) > 191) {
        return new WP_Error(
            'invalid_token',
            'Token manquant ou invalide.',
            array('status' => 400)
        );
    }

    if (!is_email($email)) {
        return new WP_Error(
            'invalid_email',
            'Adresse email invalide.',
            array('status' => 400)
        );
    }

    if ($score !== null && ($score < 0 || $score > 100)) {
        return new WP_Error(
            'invalid_score',
            'Score invalide.',
            array('status' => 400)
        );
    }


    // =================================================
    // 4. RESERVATION DU TOKEN
    // =================================================

    $now = current_time('mysql');

    $insert_data = array(
        'token'      => $token,
        'website'    => $testedUrl,
        'email'      => $email,
        'status'     => 'pending',
        'created_at' => $now,
        'updated_at' => $now,
    );

    $formats = array('%s', '%s', '%s', '%s', '%s');

    if ($score !== null) {
        $insert_data['score'] = $score;
        $formats[] = '%d';
    }

    $inserted = $wpdb->insert(
        $table,
        $insert_data,
        $formats
    );

    $reserved = ($inserted === 1);

    // Si le token existe déjà, on examine son statut.
    if (!$reserved) {

        $existing = $wpdb->get_row(
            $wpdb->prepare(
                "SELECT * FROM $table WHERE token = %s",
                $token
            )
        );

        // Erreur SQL ou table indisponible

        if (!$existing) {
            return new WP_Error(
                'database_error',
                'Impossible d’enregistrer la demande.',
                array('status' => 500)
            );
        }

        // Empêcher la réutilisation du token avec un autre email

        if (strtolower($existing->email) !== strtolower($email)) {
            return new WP_Error(
                'token_email_conflict',
                'Ce diagnostic est déjà associé à une autre adresse email.',
                array('status' => 409)
            );
        }

        // Email déjà envoyé

        if ($existing->status === 'sent') {

            return new WP_REST_Response(array(
                'success'      => true,
                'already_sent' => true,
                'message'      => 'Cet email a déjà été envoyé.',
            ), 200);
        }

        // Un autre traitement est en cours

        if ($existing->status === 'pending') {

            return new WP_REST_Response(array(
                'success' => false,
                'pending' => true,
                'message' => 'Un envoi est déjà en cours.',
            ), 409);
        }

        // Autoriser une nouvelle tentative après un échec.
        // L'UPDATE conditionnel garantit qu'un seul appel
        // peut réserver cette nouvelle tentative.

        if ($existing->status === 'failed') {
            $retry_data = array(
                'status'        => 'pending',
                'error_message' => null,
                'updated_at'    => $now,
            );

            $retry_formats = array('%s', '%s', '%s');

            if ($score !== null) {
                $retry_data['score'] = $score;
                $retry_formats[] = '%d';
            }
            $updated = $wpdb->update(
                $table,
                $retry_data,
                array(
                    'token'  => $token,
                    'status' => 'failed',
                ),
                $retry_formats,
                array('%s', '%s')
            );

            if ($updated !== 1) {

                return new WP_REST_Response(array(
                    'success' => false,
                    'pending' => true,
                    'message' => 'Une autre tentative est déjà en cours.',
                ), 409);
            }

            $reserved = true;
        }
    }

    if (!$reserved) {
        return new WP_Error(
            'reservation_failed',
            'Impossible de réserver cet envoi.',
            array('status' => 500)
        );
    }


    // =================================================
    // 5. CONSTRUCTION DE L'EMAIL
    // =================================================

    $result_url = add_query_arg(
        'token',
        $token,
        WEBSITE_URL.'/test-visibilite'
    );
    if (!defined('WEBSITE_URL')) {
        error_log('WEBSITE_URL is not defined');
    } else {
        error_log('WEBSITE_URL is defined: ' . WEBSITE_URL);
    }
    $subject = 'Votre diagnostic de visibilité en ligne';

    $score_html = $score !== null
        ? '<p style="font-size:18px;"><strong>Votre score de visibilité : '
            . esc_html($score) . '/100</strong></p>'
        : '';

    $tested_url_html = $testedUrl !== null
        ? '<p>Site analysé :  <a href="'
           . esc_html($testedUrl) . '">'
            . esc_html($testedUrl) . '</a></p>'
        : '';

    $message = '
    <!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>

    <body style="margin:0;padding:30px 15px;background:#f4f6f9;font-family:Arial,sans-serif;color:#263449;">

        <div style="max-width:600px;margin:0 auto;background:#ffffff;padding:35px;border-radius:10px;">

            <h1 style="font-size:23px;color:#17345c;">
                Votre diagnostic de visibilité est prêt !
            </h1>

            <p>Bonjour,</p>

            <p>
                Votre analyse de visibilité en ligne est terminée.
                Vous pouvez retrouver votre diagnostic en cliquant
                sur le bouton ci-dessous.
            </p>

            ' . $tested_url_html . '

            ' . $score_html . '

            <p style="text-align:center;margin:35px 0;">
                <a href="' . esc_url($result_url) . '"
                   style="display:inline-block;padding:15px 25px;background:#1d65ad;color:#ffffff;text-decoration:none;border-radius:6px;font-weight:bold;">
                    Consulter mon diagnostic
                </a>
            </p>

            <p style="font-size:13px;color:#68778a;">
                Si le bouton ne fonctionne pas, copiez ce lien :
                <br>
                <a href="' . esc_url($result_url) . '">'
                    . esc_html($result_url) .
                '</a>
            </p>

            <hr style="border:0;border-top:1px solid #e5e9ef;margin:30px 0;">

            <p style="font-size:13px;color:#68778a;">
                À bientôt,<br>
                Gaël Gérard<br>
                <a href="https://www.gaelgerard.com">www.gaelgerard.com</a>
            </p>

        </div>

    </body>
    </html>';


    // =================================================
    // 6. ENVOI DE L'EMAIL
    // =================================================

    $headers = array(
        'Content-Type: text/html; charset=UTF-8',
        'From: Gaël Gérard <info@gaelgerard.com>',
        'Bcc: info@gaelgerard.com',
    );

    $sent = wp_mail(
        $email,
        $subject,
        $message,
        $headers
    );


    // =================================================
    // 7. MISE A JOUR DE L'HISTORIQUE
    // =================================================

    if ($sent) {

        $updated = $wpdb->update(
            $table,
            array(
                'status'        => 'sent',
                'sent_at'       => current_time('mysql'),
                'error_message' => null,
                'updated_at'    => current_time('mysql'),
            ),
            array('token' => $token),
            array('%s', '%s', '%s', '%s'),
            array('%s')
        );

        if ($updated === false) {
            error_log(
                '[GGCOM Visibility] Email envoyé mais historique non actualisé : '
                . $token
            );
        }

        return new WP_REST_Response(array(
            'success'        => true,
            'already_sent'   => false,
            'message'        => 'Email envoyé avec succès.',
            'history_updated' => ($updated !== false),
        ), 200);

    }


    // En cas d'échec, autoriser une nouvelle tentative

    $mail_error = 'wp_mail() a retourné false.';

    $wpdb->update(
        $table,
        array(
            'status'        => 'failed',
            'error_message' => $mail_error,
            'updated_at'    => current_time('mysql'),
        ),
        array('token' => $token),
        array('%s', '%s', '%s'),
        array('%s')
    );

    error_log(
        '[GGCOM Visibility] Échec envoi email : ' . $token
    );

    return new WP_Error(
        'email_send_failed',
        'Impossible d’envoyer le diagnostic par email.',
        array('status' => 500)
    );

}
