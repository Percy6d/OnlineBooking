<?php

ini_set("display_errors", 1);

require_once("../../classes/Categorys.php");

$getData = json_decode(file_get_contents("php://input", true));
if(!empty($getData)){
    $types = new Category();
    if(isset($getData->name)){
        $newCategory = $types->newCategory($getData->name);
        if(is_array($newCategory) || is_object($newCategory)){
            echo json_encode($newCategory);
        } else {
            echo $newCategory;
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