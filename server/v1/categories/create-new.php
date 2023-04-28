<?php

ini_set("display_errors", 1);

require_once("../../classes/Category.php");

$getData = json_decode(file_get_contents("php://input", true));
if(!empty($getData)){
    $category = new Category();
    $newCategory = $category->newCategory($getData);
    if(is_array($newCategory) || is_object($newCategory)){
        echo json_encode($newCategory);
    } else {
        echo $newCategory;
    }
} else {
    echo json_encode("Empty post data");
    if($_SERVER['REQUEST_METHOD'] == 'GET' || $_SERVER['REQUEST_METHOD'] == 'POST' || $_SERVER['REQUEST_METHOD'] == 'PUT' || $_SERVER['REQUEST_METHOD'] == 'PATCH' || $_SERVER['REQUEST_METHOD'] == 'DELETE'){http_response_code(417);}
}

?>