<?php

ini_set("display_errors", 1);

require_once("../../classes/Users.php");

$getData = json_decode(file_get_contents("php://input", true));

if(isset($getData)){
    if(isset($getData->identifier)){
        $users = new Users();
        $getDetails = $users->getDetails($getData->identifier);
        echo json_encode($getDetails);
    } else {
        echo json_encode("No 'identifier' found in object");
        if($_SERVER['REQUEST_METHOD'] == 'GET' || $_SERVER['REQUEST_METHOD'] == 'POST' || $_SERVER['REQUEST_METHOD'] == 'PUT' || $_SERVER['REQUEST_METHOD'] == 'PATCH' || $_SERVER['REQUEST_METHOD'] == 'DELETE'){http_response_code(417);}
    }

} else {
    echo json_encode("Empty post data");
    if($_SERVER['REQUEST_METHOD'] == 'GET' || $_SERVER['REQUEST_METHOD'] == 'POST' || $_SERVER['REQUEST_METHOD'] == 'PUT' || $_SERVER['REQUEST_METHOD'] == 'PATCH' || $_SERVER['REQUEST_METHOD'] == 'DELETE'){http_response_code(417);}
}

?>