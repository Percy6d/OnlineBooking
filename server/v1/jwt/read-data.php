<?php

ini_set("display_errors", 1);

require_once("../../config/MyJWT.php");

$jwt = new MyJWT();
$jwtDecode = $jwt->decode();
if(is_array($jwtDecode) || is_object($jwtDecode)){
    echo json_encode($jwtDecode);
} else {
    echo $jwtDecode;
}

?>