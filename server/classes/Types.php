<?php
// Getting all required files
require_once("../../config/uidGenerator.php");
require_once("../../config/datetimeGenerator.php");
require_once("../../config/ConnectDB.php");
class Types {
    public $conn;
    public $connectDB;
    function __construct(){
        $connectDB = new ConnectDB();
        $this->connectDB = $connectDB;
        $this->conn = $connectDB->connect();
    }
    function newType($name){
        $generatedUID = new UIDGenerator();
        $dateTimeGenerate = new DateTimeGenerator();
        $uid = $generatedUID->getUID(20, null);
        $dateTimeUTC = $dateTimeGenerate->toUTC();
        // Trimming name before inserting to DB
        $name = trim(strtolower($name));
        try {
            $query = $this->conn->prepare("INSERT INTO types (uid, name, timeCreated, timeUpdated) VALUES (:uid, :name, :timeCreated, :timeUpdated)");
            $query->bindParam(":uid", $uid);
            $query->bindParam(":name", $name);
            $query->bindParam(":timeCreated", $dateTimeUTC);
            $query->bindParam(":timeUpdated", $dateTimeUTC);
            if($query->execute()){
                $output = "New type \"" . $name . "\" created";
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
    function editType($obj){
        $dateTimeGenerate = new DateTimeGenerator();
        $dateTimeUTC = $dateTimeGenerate->toUTC();
        if(!isset($obj->uid)){
            if($_SERVER['REQUEST_METHOD'] == 'GET' || $_SERVER['REQUEST_METHOD'] == 'POST'){http_response_code(406);}
            exit("No uid property was found in your object");
        }
        if(!isset($obj->name)){
            if($_SERVER['REQUEST_METHOD'] == 'GET' || $_SERVER['REQUEST_METHOD'] == 'POST'){http_response_code(406);}
            exit("No name property was found in your object");
        } else {
            // Trimming name before inserting to DB
            $name = trim(strtolower($obj->name));
        }
        try {
            $query = $this->conn->prepare("UPDATE types SET name = :name, timeUpdated = :timeUpdated WHERE uid = :uid");
            $query->bindParam(":uid", $obj->uid);
            $query->bindParam(":name", $name);
            $query->bindParam(":timeUpdated", $dateTimeUTC);
            if($query->execute()){
                $output = "UID \"". $obj->uid ."\" has been updated";
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
    function deleteType($obj){
        if(!isset($obj->uid)){
            if($_SERVER['REQUEST_METHOD'] == 'GET' || $_SERVER['REQUEST_METHOD'] == 'POST'){http_response_code(406);}
            exit("No uid property was found in your object");
        }
        if(!isset($obj->name)){
            if($_SERVER['REQUEST_METHOD'] == 'GET' || $_SERVER['REQUEST_METHOD'] == 'POST'){http_response_code(406);}
            exit("No name property was found in your object");
        } else {
            // Trimming name before inserting to DB
            $name = trim(strtolower($obj->name));
        }
        try {
            $query = $this->conn->prepare("UPDATE types SET name = :name, timeUpdated = :timeUpdated WHERE uid = :uid");
            $query->bindParam(":uid", $obj->uid);
            $query->bindParam(":name", $name);
            $query->bindParam(":timeUpdated", $dateTimeUTC);
            if($query->execute()){
                $output = "UID \"". $obj->uid ."\" has been updated";
                if($_SERVER['REQUEST_METHOD'] == 'GET' || $_SERVER['REQUEST_METHOD'] == 'POST' || $_SERVER['REQUEST_METHOD'] == 'PUT' || $_SERVER['REQUEST_METHOD'] == 'PATCH' || $_SERVER['REQUEST_METHOD'] == 'DELETE'){http_response_code(201);}
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