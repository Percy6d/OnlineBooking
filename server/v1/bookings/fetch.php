<?php

ini_set("display_errors", 1);

require_once("../../classes/Booking.php");

$getData = json_decode(file_get_contents("php://input", true));
if(!empty($getData)){
    $booking = new Booking();
    if(isset($getData->identifier)){
        $getBooking = $booking->getBooking($getData->identifier);
        if(is_array($getBooking) || is_object($getBooking)){
            echo json_encode($getBooking);
        } else {
            echo $getBooking;
        }
    } else {
        if($_SERVER['REQUEST_METHOD'] == 'GET' || $_SERVER['REQUEST_METHOD'] == 'POST' || $_SERVER['REQUEST_METHOD'] == 'PUT' || $_SERVER['REQUEST_METHOD'] == 'PATCH' || $_SERVER['REQUEST_METHOD'] == 'DELETE'){http_response_code(406);}
        exit("No identifier property was found in your object");
    }
} else {
    echo json_encode("Empty post data");
    if($_SERVER['REQUEST_METHOD'] == 'GET' || $_SERVER['REQUEST_METHOD'] == 'POST' || $_SERVER['REQUEST_METHOD'] == 'PUT' || $_SERVER['REQUEST_METHOD'] == 'PATCH' || $_SERVER['REQUEST_METHOD'] == 'DELETE'){http_response_code(417);}
}

?>