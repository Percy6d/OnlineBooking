<?php

ini_set("display_errors", 1);

require_once("../../classes/Users.php");

$users = new Users();
$getAllUsers = $users->getAllUsers();
if(is_array($getAllUsers) || is_object($getAllUsers)){
    echo json_encode($getAllUsers);
} else {
    echo $getAllUsers;
}

?>