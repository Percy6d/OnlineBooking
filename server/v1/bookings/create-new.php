<?php

ini_set("display_errors", 1);

require_once("../../classes/Booking.php");

$getData = json_decode(file_get_contents("php://input", true));
if(!empty($getData)){
    $booking = new Booking();
    $newBooking = $booking->newBooking($getData);
    if(is_array($newBooking) || is_object($newBooking)){
        echo json_encode($newBooking);
    } else {
        echo $newBooking;
    }
} else {
    echo json_encode("Empty post data");
    if($_SERVER['REQUEST_METHOD'] == 'GET' || $_SERVER['REQUEST_METHOD'] == 'POST' || $_SERVER['REQUEST_METHOD'] == 'PUT' || $_SERVER['REQUEST_METHOD'] == 'PATCH' || $_SERVER['REQUEST_METHOD'] == 'DELETE'){http_response_code(417);}
}

?>