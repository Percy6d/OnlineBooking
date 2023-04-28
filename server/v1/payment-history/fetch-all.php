<?php

ini_set("display_errors", 1);

require_once("../../classes/PaymentsHistory.php");

$ph = new PaymentHistory();
$getAllPaymentHistories = $ph->getAllPaymentHistories();
if(is_array($getAllPaymentHistories) || is_object($getAllPaymentHistories)){
    echo json_encode($getAllPaymentHistories);
} else {
    echo $getAllPaymentHistories;
}

?>