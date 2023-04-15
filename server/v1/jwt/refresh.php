<?php

ini_set("display_errors", 1);

require_once("../../config/MyJWT.php");

$getData = json_decode(file_get_contents("php://input", true));

if(!empty($getData)){
    $jwt = new MyJWT();
    $jwtDecode = $jwt->decode();
    if(is_array($jwtDecode) || is_object($jwtDecode)){
        $jwtRefresh = $jwt->refresh($getData);
        if(is_array($jwtRefresh) || is_object($jwtRefresh)){
            echo json_encode($jwtRefresh);
        } else {
            echo $jwtRefresh;
        }
    }
    else {
        $output = "Still in use";
        if($_SERVER['REQUEST_METHOD'] == 'GET' || $_SERVER['REQUEST_METHOD'] == 'POST'){http_response_code(208);}
        echo $output;
    }
} else {
    echo json_encode("Empty post data");
    if($_SERVER['REQUEST_METHOD'] == 'GET' || $_SERVER['REQUEST_METHOD'] == 'POST'){http_response_code(417);}
}

?>