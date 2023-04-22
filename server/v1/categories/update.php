<?php

ini_set("display_errors", 1);

require_once("../../classes/Category.php");

$getData = json_decode(file_get_contents("php://input", true));
if(!empty($getData)){
    $category = new Category();
    $editCategory = $category->editCategory($getData);
    if(is_array($editCategory) || is_object($editCategory)){
        echo json_encode($editCategory);
    } else {
        echo $editCategory;
    }
} else {
    echo json_encode("Empty post data");
    if($_SERVER['REQUEST_METHOD'] == 'GET' || $_SERVER['REQUEST_METHOD'] == 'POST'){http_response_code(417);}
}

?>