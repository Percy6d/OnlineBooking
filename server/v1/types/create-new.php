<?php

ini_set("display_errors", 1);

require_once("../../classes/Types.php");

$getData = json_decode(file_get_contents("php://input", true));
if(!empty($getData)){
    $types = new Types();
    if(isset($getData->name)){
        $newType = $types->newType($getData->name);
        if(is_array($newType) || is_object($newType)){
            echo json_encode($newType);
        } else {
            echo $newType;
        }
    } else {
        if($_SERVER['REQUEST_METHOD'] == 'GET' || $_SERVER['REQUEST_METHOD'] == 'POST'){http_response_code(406);}
        exit("No name property was found in your object");
    }
} else {
    echo json_encode("Empty post data");
    if($_SERVER['REQUEST_METHOD'] == 'GET' || $_SERVER['REQUEST_METHOD'] == 'POST'){http_response_code(417);}
}

?>