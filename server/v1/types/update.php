<?php

ini_set("display_errors", 1);

require_once("../../classes/Types.php");

$getData = json_decode(file_get_contents("php://input", true));
if(!empty($getData)){
    $types = new Types();
    $editType = $types->editType($getData);
    if(is_array($editType) || is_object($editType)){
        echo json_encode($editType);
    } else {
        echo $editType;
    }
} else {
    echo json_encode("Empty post data");
    if($_SERVER['REQUEST_METHOD'] == 'GET' || $_SERVER['REQUEST_METHOD'] == 'POST' || $_SERVER['REQUEST_METHOD'] == 'PUT' || $_SERVER['REQUEST_METHOD'] == 'PATCH' || $_SERVER['REQUEST_METHOD'] == 'DELETE'){http_response_code(417);}
}

?>