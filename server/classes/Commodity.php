<?php
// Getting all required files
require_once("../../config/uidGenerator.php");
require_once("../../config/datetimeGenerator.php");
require_once("../../config/ConnectDB.php");
class Commodity {
    public $conn;
    public $connectDB;
    function __construct(){
        $connectDB = new ConnectDB();
        $this->connectDB = $connectDB;
        $this->conn = $connectDB->connect();
    }
    function newCommodity($obj){
        $generatedUID = new UIDGenerator();
        $dateTimeGenerate = new DateTimeGenerator();
        $uid = $generatedUID->getUID(20, null);
        $dateTimeUTC = $dateTimeGenerate->toUTC();
        if(!isset($obj->userID)){
            if($_SERVER['REQUEST_METHOD'] == 'GET' || $_SERVER['REQUEST_METHOD'] == 'POST'){http_response_code(406);}
            exit("No userID property was found in your object");
        } else {
            $obj->userID = (int)$obj->userID;
        }
        if(!isset($obj->categoryID)){
            if($_SERVER['REQUEST_METHOD'] == 'GET' || $_SERVER['REQUEST_METHOD'] == 'POST'){http_response_code(406);}
            exit("No categoryID property was found in your object");
        } else {
            $obj->categoryID = (int)$obj->categoryID;
        }
        if(!isset($obj->typeID)){
            if($_SERVER['REQUEST_METHOD'] == 'GET' || $_SERVER['REQUEST_METHOD'] == 'POST'){http_response_code(406);}
            exit("No typeID property was found in your object");
        } else {
            $obj->typeID = (int)$obj->typeID;
        }
        // Trimming name before inserting to DB
        if(!isset($obj->name)){
            if($_SERVER['REQUEST_METHOD'] == 'GET' || $_SERVER['REQUEST_METHOD'] == 'POST'){http_response_code(406);}
            exit("No name property was found in your object");
        } else {
            // Trimming name before inserting to DB
            $name = trim($obj->name);
        }
        try {
            $query = $this->conn->prepare("INSERT INTO commodities (uid, name, userID, categoryID, typeID, timeCreated, timeUpdated) VALUES (:uid, :name, :userID, :categoryID, :typeID, :timeCreated, :timeUpdated)");
            $query->bindParam(":uid", $uid);
            $query->bindParam(":name", $name);
            $query->bindParam(":userID", $obj->userID);
            $query->bindParam(":categoryID", $obj->categoryID);
            $query->bindParam(":typeID", $obj->typeID);
            $query->bindParam(":timeCreated", $dateTimeUTC);
            $query->bindParam(":timeUpdated", $dateTimeUTC);
            if($query->execute()){
                $lastInsertedID = $this->conn->lastInsertId();
                foreach ($obj->images as $image) {
                    $uid = $generatedUID->getUID(20, null);
                    $dateTimeUTC = $dateTimeGenerate->toUTC();
                    $queryCmd = $this->conn->prepare("INSERT INTO commodities_images (uid, url, commodityID, timeAdded) VALUES (:uid, :url, :commodityID, :timeAdded)");
                    $queryCmd->bindParam(":uid", $uid);
                    $queryCmd->bindParam(":url", $image);
                    $queryCmd->bindParam(":commodityID", $lastInsertedID);
                    $queryCmd->bindParam(":timeAdded", $dateTimeUTC);
                    $queryCmd->execute();
                }
                $output = "New commodity \"" . $name . "\" created";
                if($_SERVER['REQUEST_METHOD'] == 'GET' || $_SERVER['REQUEST_METHOD'] == 'POST' || $_SERVER['REQUEST_METHOD'] == 'PUT' || $_SERVER['REQUEST_METHOD'] == 'PATCH' || $_SERVER['REQUEST_METHOD'] == 'DELETE'){http_response_code(200);}
            }
            else {
                $output = "Something went wrong!";
                if($_SERVER['REQUEST_METHOD'] == 'GET' || $_SERVER['REQUEST_METHOD'] == 'POST' || $_SERVER['REQUEST_METHOD'] == 'PUT' || $_SERVER['REQUEST_METHOD'] == 'PATCH' || $_SERVER['REQUEST_METHOD'] == 'DELETE'){http_response_code(400);}
                
            }
        } catch (PDOException $e) {
            $output = "Query Failed: {$e->getMessage()}";
            if($_SERVER['REQUEST_METHOD'] == 'GET' || $_SERVER['REQUEST_METHOD'] == 'POST' || $_SERVER['REQUEST_METHOD'] == 'PUT' || $_SERVER['REQUEST_METHOD'] == 'PATCH' || $_SERVER['REQUEST_METHOD'] == 'DELETE'){http_response_code(400);}
            
        }
        return $output;
    }
    function verifyCommodity($uid){
        $dateTimeGenerate = new DateTimeGenerator();
        $dateTimeUTC = $dateTimeGenerate->toUTC();
        if(!isset($uid)){
            if($_SERVER['REQUEST_METHOD'] == 'GET' || $_SERVER['REQUEST_METHOD'] == 'POST'){http_response_code(406);}
            exit("No uid property was found in your object");
        }
        try {
            $status = 1;
            $query = $this->conn->prepare("UPDATE commodities SET status = :status, timeUpdated = :timeUpdated WHERE uid = :uid");
            $query->bindParam(":uid", $uid);
            $query->bindParam(":status", $status);
            $query->bindParam(":timeUpdated", $dateTimeUTC);
            if($query->execute()){
                $output = "UID \"". $uid ."\" has been been verified";
                if($_SERVER['REQUEST_METHOD'] == 'GET' || $_SERVER['REQUEST_METHOD'] == 'POST' || $_SERVER['REQUEST_METHOD'] == 'PUT' || $_SERVER['REQUEST_METHOD'] == 'PATCH' || $_SERVER['REQUEST_METHOD'] == 'DELETE'){http_response_code(200);}
            }
            else {
                $output = "Something went wrong!";
                if($_SERVER['REQUEST_METHOD'] == 'GET' || $_SERVER['REQUEST_METHOD'] == 'POST' || $_SERVER['REQUEST_METHOD'] == 'PUT' || $_SERVER['REQUEST_METHOD'] == 'PATCH' || $_SERVER['REQUEST_METHOD'] == 'DELETE'){http_response_code(400);}
                
            }
        } catch (PDOException $e) {
            $output = "Query Failed: {$e->getMessage()}";
            if($_SERVER['REQUEST_METHOD'] == 'GET' || $_SERVER['REQUEST_METHOD'] == 'POST' || $_SERVER['REQUEST_METHOD'] == 'PUT' || $_SERVER['REQUEST_METHOD'] == 'PATCH' || $_SERVER['REQUEST_METHOD'] == 'DELETE'){http_response_code(400);}
            
        }
        return $output;
    }
}
?>