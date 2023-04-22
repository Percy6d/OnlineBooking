<?php

ini_set("display_errors", 1);

require_once("../../classes/Category.php");

$category = new Category();
$getAllCategories = $category->getAllCategories();
if(is_array($getAllCategories) || is_object($getAllCategories)){
    echo json_encode($getAllCategories);
} else {
    echo $getAllCategories;
}

?>