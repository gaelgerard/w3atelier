<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $dataForm = json_decode(file_get_contents("php://input"), true);
    
    if (!empty($dataForm)) {
        $ROOT = dirname( __FILE__ ) . '/wp/';
        require_once( $ROOT. 'wp-load.php' );
        $response = ggcom_react_form_save_and_notify ( $dataForm );
    } else {
        $response = array(
            'status' => 'error',
            'message' => 'No data received',
        );
    }

    echo json_encode($response);
    exit;
} else {
    echo json_encode(array('status' => 'error', 'message' => 'Invalid request method'));
    exit;
}