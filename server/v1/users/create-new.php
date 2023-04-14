<?php

ini_set("display_errors", 1);

require_once("../../classes/Users.php");

$getData = json_decode(file_get_contents("php://input", true));
if(!empty($getData)){
    $users = new Users();
    $newUser = $users->newUser($getData);
    if(is_array($newUser) || is_object($newUser)){
        echo json_encode($newUser);
    } else {
        echo $newUser;
    }
} else {
    echo json_encode("Empty post data");
    if($_SERVER['REQUEST_METHOD'] == 'GET' || $_SERVER['REQUEST_METHOD'] == 'POST'){http_response_code(417);}
}

?>