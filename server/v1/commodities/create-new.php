<?php

ini_set("display_errors", 1);

require_once("../../classes/Commodity.php");

$getData = json_decode(file_get_contents("php://input", true));
if(!empty($getData)){
    $commodity = new Commodity();
    $newCommodity = $commodity->newCommodity($getData);
    if(is_array($newCommodity) || is_object($newCommodity)){
        echo json_encode($newCommodity);
    } else {
        echo $newCommodity;
    }
} else {
    echo json_encode("Empty post data");
    if($_SERVER['REQUEST_METHOD'] == 'GET' || $_SERVER['REQUEST_METHOD'] == 'POST'){http_response_code(417);}
}

?>