<?php 
    session_start();
    header('Content-Type: application/json');

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        unset($_SESSION['customer']);
        $input = json_decode(file_get_contents('php://input'), true);
        $_SESSION['customer'] = [
            'first_name' => $input['first_name'],
            'last_name' => $input['last_name'],
            'email' => $input['email'],
            'address' => $input['address'],
            'city' => $input['city'],
            'state' => $input['state'],
            'phone' => $input['phone'],
        ];

        
        exit;
    }

    echo json_encode([
        'status' => 'success',
        'message' => 'Customer session data saved successfully.',
        'data' => $_SESSION['customer']
    ]);

?>