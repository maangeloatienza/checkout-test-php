<?php 
    session_start();
    header('Content-Type: application/json');

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        unset($_SESSION['payment']);
        $input = json_decode(file_get_contents('php://input'), true);
        $_SESSION['payment'] = [
            'card_type' => $input['card_type'] ,
            'card_number' => $input['card_number'],
            'card_exp_date' => $input['card_exp_date'],
        ];

        exit;
    }

    echo json_encode([
        'status' => 'success',
        'message' => 'Customer payment data saved successfully.',
        'data' => $_SESSION['payment']
    ]);

?>