<?php

ini_set("display_errors", 1);

require_once("../../classes/Commodity.php");

$getData = json_decode(file_get_contents("php://input", true));
if(!empty($getData)){
    $commodity = new Commodity();
    if(isset($getData->uid)){
        $flagCommodity = $commodity->flagCommodity($getData->uid);
        if(is_array($flagCommodity) || is_object($flagCommodity)){
            echo json_encode($flagCommodity);
        } else {
            echo $flagCommodity;
        }
    } else {
        if($_SERVER['REQUEST_METHOD'] == 'GET' || $_SERVER['REQUEST_METHOD'] == 'POST'){http_response_code(406);}
        exit("No uid property was found in your object");
    }
} else {
    echo json_encode("Empty post data");
    if($_SERVER['REQUEST_METHOD'] == 'GET' || $_SERVER['REQUEST_METHOD'] == 'POST'){http_response_code(417);}
}

?>