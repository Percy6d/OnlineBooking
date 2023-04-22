<?php

ini_set("display_errors", 1);

require_once("../../classes/Types.php");

$types = new Types();
$getAllTypes = $types->getAllTypes();
if(is_array($getAllTypes) || is_object($getAllTypes)){
    echo json_encode($getAllTypes);
} else {
    echo $getAllTypes;
}

?>