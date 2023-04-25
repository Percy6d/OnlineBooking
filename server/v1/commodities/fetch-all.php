<?php

ini_set("display_errors", 1);

require_once("../../classes/Commodity.php");

$commodity = new Commodity();
$getAllCommodities = $commodity->getAllCommodities();
if(is_array($getAllCommodities) || is_object($getAllCommodities)){
    echo json_encode($getAllCommodities);
} else {
    echo $getAllCommodities;
}

?>