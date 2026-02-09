<?php
/*
Plugin Name: GGCom Custom API
Description: Sécurisation du formulaire React vers WordPress
*/

// On utilise un hook WordPress pour les headers afin d'éviter le "headers already sent"
add_action('init', function() {
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