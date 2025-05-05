<?php 
    session_start();
    require_once '../classes/Database.php';
    header('Content-Type: application/json');
    

    try {
        $db = Database::getInstance()->getConnection();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $input = json_decode(file_get_contents('php://input'), true);
            $customer = $input['customer'];
            $payment = $input['payment'];
    
            $customerId = null;
            $paymentId = null;
    
            $db->beginTransaction();
    
                $customerDetails = $db->prepare("INSERT INTO customer_details (first_name, last_name, email, address, city, state, phone) VALUES (:first_name, :last_name, :email, :address, :city, :state, :phone)");
                $customerDetails->bindParam(':first_name',$customer['first_name']);
                $customerDetails->bindParam(':last_name', $customer['last_name']);
                $customerDetails->bindParam(':email', $customer['email']);
                $customerDetails->bindParam(':address', $customer['address']);
                $customerDetails->bindParam(':city', $customer['city']);
                $customerDetails->bindParam(':state', $customer['state']);
                $customerDetails->bindParam(':phone', $customer['phone']);
                $customerDetails->execute();
                $customerId = $db->lastInsertId();
    
                $paymentDetails = $db->prepare("INSERT INTO payment_details (card_type, card_number, card_exp_date) VALUES (:card_type, :card_number, :card_exp_date)");
                $paymentDetails->bindParam(':card_type', $payment['card_type']);
                $paymentDetails->bindParam(':card_number', $payment['card_number']);
                $paymentDetails->bindParam(':card_exp_date', $payment['card_exp_date']);
                $paymentDetails->execute();
                $paymentId = $db->lastInsertId();
    
            $db->commit();
     
            echo json_encode([
                'status' => 'success',
                'message' => 'Customer payment data saved successfully.',
                'data' => [
                    'payment' => $payment,
                    'customer' => $customer,
                ]
            ]);
            exit;
        }
    } catch (PDOException $e) {
        $db->rollBack();
        echo json_encode([
            'status' => 'error',
            'message' => 'Database error: ' . $e->getMessage()
        ]);
        exit;
    } catch (Exception $e) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Error: ' . $e->getMessage()
        ]);
        exit;
    }


?>