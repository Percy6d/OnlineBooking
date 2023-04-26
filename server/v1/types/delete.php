<?php

ini_set("display_errors", 1);

require_once("../../classes/Types.php");

$getData = json_decode(file_get_contents("php://input", true));
if(!empty($getData)){
    $types = new Types();
    if(isset($getData->uid)){
        $deleteType = $types->deleteType($getData->uid);
        if(is_array($deleteType) || is_object($deleteType)){
            echo json_encode($deleteType);
        } else {
            echo $deleteType;
        }
    } else {
        if($_SERVER['REQUEST_METHOD'] == 'GET' || $_SERVER['REQUEST_METHOD'] == 'POST' || $_SERVER['REQUEST_METHOD'] == 'PUT' || $_SERVER['REQUEST_METHOD'] == 'PATCH' || $_SERVER['REQUEST_METHOD'] == 'DELETE'){http_response_code(406);}
        exit("No uid property was found in your object");
    }
} else {
    echo json_encode("Empty post data");
    if($_SERVER['REQUEST_METHOD'] == 'GET' || $_SERVER['REQUEST_METHOD'] == 'POST' || $_SERVER['REQUEST_METHOD'] == 'PUT' || $_SERVER['REQUEST_METHOD'] == 'PATCH' || $_SERVER['REQUEST_METHOD'] == 'DELETE'){http_response_code(417);}
}

?>