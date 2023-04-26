<?php

ini_set("display_errors", 1);

require_once("../../classes/Users.php");

$getData = json_decode(file_get_contents("php://input", true));
if(!empty($getData)){
    $users = new Users();
    $updateBasicInfo = $users->updateBasicInfo($getData);
    if(is_array($updateBasicInfo) || is_object($updateBasicInfo)){
        echo json_encode($updateBasicInfo);
    } else {
        echo $updateBasicInfo;
    }
} else {
    echo json_encode("Empty post data");
    if($_SERVER['REQUEST_METHOD'] == 'GET' || $_SERVER['REQUEST_METHOD'] == 'POST' || $_SERVER['REQUEST_METHOD'] == 'PUT' || $_SERVER['REQUEST_METHOD'] == 'PATCH' || $_SERVER['REQUEST_METHOD'] == 'DELETE'){http_response_code(400);}
}

?>