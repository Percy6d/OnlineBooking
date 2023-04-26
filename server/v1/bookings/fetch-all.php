<?php

ini_set("display_errors", 1);

require_once("../../classes/Booking.php");

$booking = new Booking();
$getAllBookings = $booking->getAllBookings();
if(is_array($getAllBookings) || is_object($getAllBookings)){
    echo json_encode($getAllBookings);
} else {
    echo $getAllBookings;
}

?>