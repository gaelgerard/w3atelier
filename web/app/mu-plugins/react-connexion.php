<?php
/*
Plugin Name: GGCom Custom API
Description: Sécurisation du formulaire React vers WordPress
*/

add_action('rest_api_init', function () {
    register_rest_route('ggcom/v1', '/form', array(
        'methods'             => 'POST',
        'callback'            => 'handle_ggcom_react_form',
        'permission_callback' => function (WP_REST_Request $request) {
            $api_key = $request->get_header('X-GGCOM-KEY');
            // CLE A CONFIGURER ICI
            return ( $api_key === env(REACT_FORM_API_KEY) );
        },
    ));
});

// Gestion du CORS pour autoriser Vercel
add_action('init', function() {
    $origin = $_SERVER['HTTP_ORIGIN'] ?? '';

    // Liste des domaines autorisés (Vercel, Production avec et sans www)
    $allowed_origins = [
        'https://www.gaelgerard.com',
        'https://gaelgerard.com',
        'https://votre-projet-vercel.vercel.app' // Utile pour vos tests de déploiement
    ];

    if (in_array($origin, $allowed_origins)) {
        header("Access-Control-Allow-Origin: " . $origin);
    }

    header("Access-Control-Allow-Methods: POST, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type, X-GGCOM-KEY");

    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
        status_header(200);
        exit;
    }
});

function handle_ggcom_react_form(WP_REST_Request $request) {
    $params = $request->get_json_params();

    // Honeypot : si ce champ invisible est rempli, on ignore silencieusement
    if (!empty($params['fax_number'])) {
        return new WP_REST_Response(array('status' => 'success', 'message' => 'Bot filtered'), 200);
    }

    if (function_exists('ggcom_react_form_save_and_notify')) {
        $result = ggcom_react_form_save_and_notify($params);
        return new WP_REST_Response($result, 200);
    }

    return new WP_Error('error', 'Function ggcom_react_form_save_and_notify not found', array('status' => 500));
}