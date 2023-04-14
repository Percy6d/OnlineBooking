<?php

ini_set("display_errors", 1);

require_once("../../classes/Users.php");

$getData = json_decode(file_get_contents("php://input", true));
if(!empty($getData)){
    $users = new Users();
    $authUser = $users->authUser($getData);
    if(is_array($authUser) || is_object($authUser)){
        echo json_encode($authUser);
    } else {
        echo $authUser;
    }
} else {
    echo json_encode("Empty post data");
    if($_SERVER['REQUEST_METHOD'] == 'GET' || $_SERVER['REQUEST_METHOD'] == 'POST'){http_response_code(417);}
}

?>