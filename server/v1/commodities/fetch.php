<?php

ini_set("display_errors", 1);

require_once("../../classes/Commodity.php");

$getData = json_decode(file_get_contents("php://input", true));
if(!empty($getData)){
    $commodity = new Commodity();
    if(isset($getData->identifier)){
        $getCommodity = $commodity->getCommodity($getData->identifier);
        if(is_array($getCommodity) || is_object($getCommodity)){
            echo json_encode($getCommodity);
        } else {
            echo $getCommodity;
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