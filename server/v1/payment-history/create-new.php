<?php

ini_set("display_errors", 1);

require_once("../../classes/PaymentsHistory.php");

$getData = json_decode(file_get_contents("php://input", true));
if(!empty($getData)){
    $ph = new PaymentHistory();
    $newPaymentHistory = $ph->newPaymentHistory($getData);
    if(is_array($newPaymentHistory) || is_object($newPaymentHistory)){
        echo json_encode($newPaymentHistory);
    } else {
        echo $newPaymentHistory;
    }
} else {
    echo json_encode("Empty post data");
    if($_SERVER['REQUEST_METHOD'] == 'GET' || $_SERVER['REQUEST_METHOD'] == 'POST' || $_SERVER['REQUEST_METHOD'] == 'PUT' || $_SERVER['REQUEST_METHOD'] == 'PATCH' || $_SERVER['REQUEST_METHOD'] == 'DELETE'){http_response_code(417);}
}

?>