<?php
// Getting all required files
require_once("../../config/uidGenerator.php");
require_once("../../config/datetimeGenerator.php");
require_once("../../config/ConnectDB.php");
require_once("Category.php");
require_once("Types.php");
require_once("Users.php");
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
            if($_SERVER['REQUEST_METHOD'] == 'GET' || $_SERVER['REQUEST_METHOD'] == 'POST' || $_SERVER['REQUEST_METHOD'] == 'PUT' || $_SERVER['REQUEST_METHOD'] == 'PATCH' || $_SERVER['REQUEST_METHOD'] == 'DELETE'){http_response_code(406);}
            exit("No userID property was found in your object");
        } else {
            $obj->userID = (int)$obj->userID;
        }
        if(!isset($obj->categoryID)){
            if($_SERVER['REQUEST_METHOD'] == 'GET' || $_SERVER['REQUEST_METHOD'] == 'POST' || $_SERVER['REQUEST_METHOD'] == 'PUT' || $_SERVER['REQUEST_METHOD'] == 'PATCH' || $_SERVER['REQUEST_METHOD'] == 'DELETE'){http_response_code(406);}
            exit("No categoryID property was found in your object");
        } else {
            $obj->categoryID = (int)$obj->categoryID;
        }
        if(!isset($obj->typeID)){
            if($_SERVER['REQUEST_METHOD'] == 'GET' || $_SERVER['REQUEST_METHOD'] == 'POST' || $_SERVER['REQUEST_METHOD'] == 'PUT' || $_SERVER['REQUEST_METHOD'] == 'PATCH' || $_SERVER['REQUEST_METHOD'] == 'DELETE'){http_response_code(406);}
            exit("No typeID property was found in your object");
        } else {
            $obj->typeID = (int)$obj->typeID;
        }
        // Trimming name before inserting to DB
        if(!isset($obj->name)){
            if($_SERVER['REQUEST_METHOD'] == 'GET' || $_SERVER['REQUEST_METHOD'] == 'POST' || $_SERVER['REQUEST_METHOD'] == 'PUT' || $_SERVER['REQUEST_METHOD'] == 'PATCH' || $_SERVER['REQUEST_METHOD'] == 'DELETE'){http_response_code(406);}
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
                if($_SERVER['REQUEST_METHOD'] == 'GET' || $_SERVER['REQUEST_METHOD'] == 'POST' || $_SERVER['REQUEST_METHOD'] == 'PUT' || $_SERVER['REQUEST_METHOD'] == 'PATCH' || $_SERVER['REQUEST_METHOD'] == 'DELETE' || $_SERVER['REQUEST_METHOD'] == 'PUT' || $_SERVER['REQUEST_METHOD'] == 'PATCH' || $_SERVER['REQUEST_METHOD'] == 'DELETE'){http_response_code(200);}
            }
            else {
                $output = "Something went wrong!";
                if($_SERVER['REQUEST_METHOD'] == 'GET' || $_SERVER['REQUEST_METHOD'] == 'POST' || $_SERVER['REQUEST_METHOD'] == 'PUT' || $_SERVER['REQUEST_METHOD'] == 'PATCH' || $_SERVER['REQUEST_METHOD'] == 'DELETE' || $_SERVER['REQUEST_METHOD'] == 'PUT' || $_SERVER['REQUEST_METHOD'] == 'PATCH' || $_SERVER['REQUEST_METHOD'] == 'DELETE'){http_response_code(400);}
                
            }
        } catch (PDOException $e) {
            $output = "Query Failed: {$e->getMessage()}";
            if($_SERVER['REQUEST_METHOD'] == 'GET' || $_SERVER['REQUEST_METHOD'] == 'POST' || $_SERVER['REQUEST_METHOD'] == 'PUT' || $_SERVER['REQUEST_METHOD'] == 'PATCH' || $_SERVER['REQUEST_METHOD'] == 'DELETE' || $_SERVER['REQUEST_METHOD'] == 'PUT' || $_SERVER['REQUEST_METHOD'] == 'PATCH' || $_SERVER['REQUEST_METHOD'] == 'DELETE'){http_response_code(400);}
            
        }
        return $output;
    }
    function verifyCommodity($uid){
        $dateTimeGenerate = new DateTimeGenerator();
        $dateTimeUTC = $dateTimeGenerate->toUTC();
        if(!isset($uid)){
            if($_SERVER['REQUEST_METHOD'] == 'GET' || $_SERVER['REQUEST_METHOD'] == 'POST' || $_SERVER['REQUEST_METHOD'] == 'PUT' || $_SERVER['REQUEST_METHOD'] == 'PATCH' || $_SERVER['REQUEST_METHOD'] == 'DELETE'){http_response_code(406);}
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
                if($_SERVER['REQUEST_METHOD'] == 'GET' || $_SERVER['REQUEST_METHOD'] == 'POST' || $_SERVER['REQUEST_METHOD'] == 'PUT' || $_SERVER['REQUEST_METHOD'] == 'PATCH' || $_SERVER['REQUEST_METHOD'] == 'DELETE' || $_SERVER['REQUEST_METHOD'] == 'PUT' || $_SERVER['REQUEST_METHOD'] == 'PATCH' || $_SERVER['REQUEST_METHOD'] == 'DELETE'){http_response_code(200);}
            }
            else {
                $output = "Something went wrong!";
                if($_SERVER['REQUEST_METHOD'] == 'GET' || $_SERVER['REQUEST_METHOD'] == 'POST' || $_SERVER['REQUEST_METHOD'] == 'PUT' || $_SERVER['REQUEST_METHOD'] == 'PATCH' || $_SERVER['REQUEST_METHOD'] == 'DELETE' || $_SERVER['REQUEST_METHOD'] == 'PUT' || $_SERVER['REQUEST_METHOD'] == 'PATCH' || $_SERVER['REQUEST_METHOD'] == 'DELETE'){http_response_code(400);}
                
            }
        } catch (PDOException $e) {
            $output = "Query Failed: {$e->getMessage()}";
            if($_SERVER['REQUEST_METHOD'] == 'GET' || $_SERVER['REQUEST_METHOD'] == 'POST' || $_SERVER['REQUEST_METHOD'] == 'PUT' || $_SERVER['REQUEST_METHOD'] == 'PATCH' || $_SERVER['REQUEST_METHOD'] == 'DELETE' || $_SERVER['REQUEST_METHOD'] == 'PUT' || $_SERVER['REQUEST_METHOD'] == 'PATCH' || $_SERVER['REQUEST_METHOD'] == 'DELETE'){http_response_code(400);}
            
        }
        return $output;
    }
    function flagCommodity($uid){
        $dateTimeGenerate = new DateTimeGenerator();
        $dateTimeUTC = $dateTimeGenerate->toUTC();
        if(!isset($uid)){
            if($_SERVER['REQUEST_METHOD'] == 'GET' || $_SERVER['REQUEST_METHOD'] == 'POST' || $_SERVER['REQUEST_METHOD'] == 'PUT' || $_SERVER['REQUEST_METHOD'] == 'PATCH' || $_SERVER['REQUEST_METHOD'] == 'DELETE'){http_response_code(406);}
            exit("No uid property was found in your object");
        }
        try {
            $status = 0;
            $query = $this->conn->prepare("UPDATE commodities SET status = :status, timeUpdated = :timeUpdated WHERE uid = :uid");
            $query->bindParam(":uid", $uid);
            $query->bindParam(":status", $status);
            $query->bindParam(":timeUpdated", $dateTimeUTC);
            if($query->execute()){
                $output = "UID \"". $uid ."\" has been been flagged";
                if($_SERVER['REQUEST_METHOD'] == 'GET' || $_SERVER['REQUEST_METHOD'] == 'POST' || $_SERVER['REQUEST_METHOD'] == 'PUT' || $_SERVER['REQUEST_METHOD'] == 'PATCH' || $_SERVER['REQUEST_METHOD'] == 'DELETE' || $_SERVER['REQUEST_METHOD'] == 'PUT' || $_SERVER['REQUEST_METHOD'] == 'PATCH' || $_SERVER['REQUEST_METHOD'] == 'DELETE'){http_response_code(200);}
            }
            else {
                $output = "Something went wrong!";
                if($_SERVER['REQUEST_METHOD'] == 'GET' || $_SERVER['REQUEST_METHOD'] == 'POST' || $_SERVER['REQUEST_METHOD'] == 'PUT' || $_SERVER['REQUEST_METHOD'] == 'PATCH' || $_SERVER['REQUEST_METHOD'] == 'DELETE' || $_SERVER['REQUEST_METHOD'] == 'PUT' || $_SERVER['REQUEST_METHOD'] == 'PATCH' || $_SERVER['REQUEST_METHOD'] == 'DELETE'){http_response_code(400);}
                
            }
        } catch (PDOException $e) {
            $output = "Query Failed: {$e->getMessage()}";
            if($_SERVER['REQUEST_METHOD'] == 'GET' || $_SERVER['REQUEST_METHOD'] == 'POST' || $_SERVER['REQUEST_METHOD'] == 'PUT' || $_SERVER['REQUEST_METHOD'] == 'PATCH' || $_SERVER['REQUEST_METHOD'] == 'DELETE' || $_SERVER['REQUEST_METHOD'] == 'PUT' || $_SERVER['REQUEST_METHOD'] == 'PATCH' || $_SERVER['REQUEST_METHOD'] == 'DELETE'){http_response_code(400);}
            
        }
        return $output;
    }
    function deleteCommodity($uid){
        if(!isset($uid)){
            if($_SERVER['REQUEST_METHOD'] == 'GET' || $_SERVER['REQUEST_METHOD'] == 'POST' || $_SERVER['REQUEST_METHOD'] == 'PUT' || $_SERVER['REQUEST_METHOD'] == 'PATCH' || $_SERVER['REQUEST_METHOD'] == 'DELETE'){http_response_code(406);}
            exit("No uid property was found in your object");
        }
        try {
            $status = 0;
            $query = $this->conn->prepare("DELETE FROM commodities WHERE uid = :uid");
            $query->bindParam(":uid", $uid);
            if($query->execute()){
                $output = "UID \"". $uid ."\" has been been deleted";
                if($_SERVER['REQUEST_METHOD'] == 'GET' || $_SERVER['REQUEST_METHOD'] == 'POST' || $_SERVER['REQUEST_METHOD'] == 'PUT' || $_SERVER['REQUEST_METHOD'] == 'PATCH' || $_SERVER['REQUEST_METHOD'] == 'DELETE' || $_SERVER['REQUEST_METHOD'] == 'PUT' || $_SERVER['REQUEST_METHOD'] == 'PATCH' || $_SERVER['REQUEST_METHOD'] == 'DELETE'){http_response_code(200);}
            }
            else {
                $output = "Something went wrong!";
                if($_SERVER['REQUEST_METHOD'] == 'GET' || $_SERVER['REQUEST_METHOD'] == 'POST' || $_SERVER['REQUEST_METHOD'] == 'PUT' || $_SERVER['REQUEST_METHOD'] == 'PATCH' || $_SERVER['REQUEST_METHOD'] == 'DELETE' || $_SERVER['REQUEST_METHOD'] == 'PUT' || $_SERVER['REQUEST_METHOD'] == 'PATCH' || $_SERVER['REQUEST_METHOD'] == 'DELETE'){http_response_code(400);}
                
            }
        } catch (PDOException $e) {
            $output = "Query Failed: {$e->getMessage()}";
            if($_SERVER['REQUEST_METHOD'] == 'GET' || $_SERVER['REQUEST_METHOD'] == 'POST' || $_SERVER['REQUEST_METHOD'] == 'PUT' || $_SERVER['REQUEST_METHOD'] == 'PATCH' || $_SERVER['REQUEST_METHOD'] == 'DELETE' || $_SERVER['REQUEST_METHOD'] == 'PUT' || $_SERVER['REQUEST_METHOD'] == 'PATCH' || $_SERVER['REQUEST_METHOD'] == 'DELETE'){http_response_code(400);}
            
        }
        return $output;
    }
    function getAllCommodities(){
        $category = new Category();
        $types = new Types();
        $users = new Users();
        try {
            $query = $this->conn->prepare("SELECT * FROM commodities LIMIT 20");
            if($query->execute()){
                if($query->rowCount() > 0){
                    $commodities = $query->fetchAll(PDO::FETCH_ASSOC);
                    $output = array();
                    foreach($commodities as $commodity){
                        if($commodity["status"] == 1){
                            $commodity["status"] = true;
                        } else {
                            $commodity["status"] = false;
                        }
                        $commodityID = $commodity["id"];
                        $categoryID = $commodity["categoryID"];
                        $typeID = $commodity["typeID"];
                        $userID = $commodity["userID"];
                        $getCategory = $category->getCategory($categoryID);
                        $commodity["category"] = $getCategory;
                        $getType = $types->getType($typeID);
                        $commodity["type"] = $getType;
                        $getDetails = $users->getDetails($userID);
                        $commodity["user"] = $getDetails;
                        $commodityImages = $this->getAllCommodityImages($commodityID);
                        $commodity["images"] = $commodityImages;
                        unset($commodity["categoryID"]);
                        unset($commodity["typeID"]);
                        unset($commodity["userID"]);
                        $output[] = $commodity;
                    }
                    if($_SERVER['REQUEST_METHOD'] == 'GET' || $_SERVER['REQUEST_METHOD'] == 'POST' || $_SERVER['REQUEST_METHOD'] == 'PUT' || $_SERVER['REQUEST_METHOD'] == 'PATCH' || $_SERVER['REQUEST_METHOD'] == 'DELETE' || $_SERVER['REQUEST_METHOD'] == 'PUT' || $_SERVER['REQUEST_METHOD'] == 'PATCH' || $_SERVER['REQUEST_METHOD'] == 'DELETE'){http_response_code(200);}
                } else {
                    $output = "No commodity found. Try creating one.";
                    if($_SERVER['REQUEST_METHOD'] == 'GET' || $_SERVER['REQUEST_METHOD'] == 'POST' || $_SERVER['REQUEST_METHOD'] == 'PUT' || $_SERVER['REQUEST_METHOD'] == 'PATCH' || $_SERVER['REQUEST_METHOD'] == 'DELETE' || $_SERVER['REQUEST_METHOD'] == 'PUT' || $_SERVER['REQUEST_METHOD'] == 'PATCH' || $_SERVER['REQUEST_METHOD'] == 'DELETE'){http_response_code(200);}
                }
            }
            else {
                $output = "Something went wrong!";
                if($_SERVER['REQUEST_METHOD'] == 'GET' || $_SERVER['REQUEST_METHOD'] == 'POST' || $_SERVER['REQUEST_METHOD'] == 'PUT' || $_SERVER['REQUEST_METHOD'] == 'PATCH' || $_SERVER['REQUEST_METHOD'] == 'DELETE' || $_SERVER['REQUEST_METHOD'] == 'PUT' || $_SERVER['REQUEST_METHOD'] == 'PATCH' || $_SERVER['REQUEST_METHOD'] == 'DELETE'){http_response_code(400);}
                
            }
        } catch (PDOException $e) {
            $output = "Query Failed: {$e->getMessage()}";
            if($_SERVER['REQUEST_METHOD'] == 'GET' || $_SERVER['REQUEST_METHOD'] == 'POST' || $_SERVER['REQUEST_METHOD'] == 'PUT' || $_SERVER['REQUEST_METHOD'] == 'PATCH' || $_SERVER['REQUEST_METHOD'] == 'DELETE' || $_SERVER['REQUEST_METHOD'] == 'PUT' || $_SERVER['REQUEST_METHOD'] == 'PATCH' || $_SERVER['REQUEST_METHOD'] == 'DELETE'){http_response_code(400);}
            
        }
        return $output;
    }
    function getCommodity($identifier){
        $category = new Category();
        $types = new Types();
        $users = new Users();
        try {
            $query = $this->conn->prepare("SELECT * FROM commodities WHERE id = :identifier OR uid = :identifier");
            $query->bindParam(":identifier", $identifier);
            if($query->execute()){
                if($query->rowCount() > 0){
                    $commodity = $query->fetch(PDO::FETCH_ASSOC);
                    if($commodity["status"] == 1){
                        $commodity["status"] = true;
                    } else {
                        $commodity["status"] = false;
                    }
                    $commodityID = $commodity["id"];
                    $categoryID = $commodity["categoryID"];
                    $typeID = $commodity["typeID"];
                    $userID = $commodity["userID"];
                    $getCategory = $category->getCategory($categoryID);
                    $commodity["category"] = $getCategory;
                    $getType = $types->getType($typeID);
                    $commodity["type"] = $getType;
                    $getDetails = $users->getDetails($userID);
                    $commodity["user"] = $getDetails;
                    $commodityImages = $this->getAllCommodityImages($commodityID);
                    $commodity["images"] = $commodityImages;
                    unset($commodity["categoryID"]);
                    unset($commodity["typeID"]);
                    unset($commodity["userID"]);
                    $output = $commodity;
                    if($_SERVER['REQUEST_METHOD'] == 'GET' || $_SERVER['REQUEST_METHOD'] == 'POST' || $_SERVER['REQUEST_METHOD'] == 'PUT' || $_SERVER['REQUEST_METHOD'] == 'PATCH' || $_SERVER['REQUEST_METHOD'] == 'DELETE' || $_SERVER['REQUEST_METHOD'] == 'PUT' || $_SERVER['REQUEST_METHOD'] == 'PATCH' || $_SERVER['REQUEST_METHOD'] == 'DELETE'){http_response_code(200);}
                } else {
                    $output = "No commodity found. Try creating one.";
                    if($_SERVER['REQUEST_METHOD'] == 'GET' || $_SERVER['REQUEST_METHOD'] == 'POST' || $_SERVER['REQUEST_METHOD'] == 'PUT' || $_SERVER['REQUEST_METHOD'] == 'PATCH' || $_SERVER['REQUEST_METHOD'] == 'DELETE' || $_SERVER['REQUEST_METHOD'] == 'PUT' || $_SERVER['REQUEST_METHOD'] == 'PATCH' || $_SERVER['REQUEST_METHOD'] == 'DELETE'){http_response_code(200);}
                }
            }
            else {
                $output = "Something went wrong!";
                if($_SERVER['REQUEST_METHOD'] == 'GET' || $_SERVER['REQUEST_METHOD'] == 'POST' || $_SERVER['REQUEST_METHOD'] == 'PUT' || $_SERVER['REQUEST_METHOD'] == 'PATCH' || $_SERVER['REQUEST_METHOD'] == 'DELETE' || $_SERVER['REQUEST_METHOD'] == 'PUT' || $_SERVER['REQUEST_METHOD'] == 'PATCH' || $_SERVER['REQUEST_METHOD'] == 'DELETE'){http_response_code(400);}
                
            }
        } catch (PDOException $e) {
            $output = "Query Failed: {$e->getMessage()}";
            if($_SERVER['REQUEST_METHOD'] == 'GET' || $_SERVER['REQUEST_METHOD'] == 'POST' || $_SERVER['REQUEST_METHOD'] == 'PUT' || $_SERVER['REQUEST_METHOD'] == 'PATCH' || $_SERVER['REQUEST_METHOD'] == 'DELETE' || $_SERVER['REQUEST_METHOD'] == 'PUT' || $_SERVER['REQUEST_METHOD'] == 'PATCH' || $_SERVER['REQUEST_METHOD'] == 'DELETE'){http_response_code(400);}
            
        }
        return $output;
    }
    function getAllCommodityImages($commodityID){
        try {
            $query = $this->conn->prepare("SELECT * FROM commodities_images");
            if($query->execute()){
                if($query->rowCount() > 0){
                    $commodityImages = $query->fetchAll(PDO::FETCH_ASSOC);
                    $output = array();
                    foreach($commodityImages as $commodityImage){
                        unset($commodityImage["commodityID"]);
                        $output[] = $commodityImage;
                    }
                    if($_SERVER['REQUEST_METHOD'] == 'GET' || $_SERVER['REQUEST_METHOD'] == 'POST' || $_SERVER['REQUEST_METHOD'] == 'PUT' || $_SERVER['REQUEST_METHOD'] == 'PATCH' || $_SERVER['REQUEST_METHOD'] == 'DELETE' || $_SERVER['REQUEST_METHOD'] == 'PUT' || $_SERVER['REQUEST_METHOD'] == 'PATCH' || $_SERVER['REQUEST_METHOD'] == 'DELETE'){http_response_code(200);}
                } else {
                    $output = "No type found. Try creating one.";
                    if($_SERVER['REQUEST_METHOD'] == 'GET' || $_SERVER['REQUEST_METHOD'] == 'POST' || $_SERVER['REQUEST_METHOD'] == 'PUT' || $_SERVER['REQUEST_METHOD'] == 'PATCH' || $_SERVER['REQUEST_METHOD'] == 'DELETE' || $_SERVER['REQUEST_METHOD'] == 'PUT' || $_SERVER['REQUEST_METHOD'] == 'PATCH' || $_SERVER['REQUEST_METHOD'] == 'DELETE'){http_response_code(200);}
                }
            }
            else {
                $output = "Something went wrong!";
                if($_SERVER['REQUEST_METHOD'] == 'GET' || $_SERVER['REQUEST_METHOD'] == 'POST' || $_SERVER['REQUEST_METHOD'] == 'PUT' || $_SERVER['REQUEST_METHOD'] == 'PATCH' || $_SERVER['REQUEST_METHOD'] == 'DELETE' || $_SERVER['REQUEST_METHOD'] == 'PUT' || $_SERVER['REQUEST_METHOD'] == 'PATCH' || $_SERVER['REQUEST_METHOD'] == 'DELETE'){http_response_code(400);}
                
            }
        } catch (PDOException $e) {
            $output = "Query Failed: {$e->getMessage()}";
            if($_SERVER['REQUEST_METHOD'] == 'GET' || $_SERVER['REQUEST_METHOD'] == 'POST' || $_SERVER['REQUEST_METHOD'] == 'PUT' || $_SERVER['REQUEST_METHOD'] == 'PATCH' || $_SERVER['REQUEST_METHOD'] == 'DELETE' || $_SERVER['REQUEST_METHOD'] == 'PUT' || $_SERVER['REQUEST_METHOD'] == 'PATCH' || $_SERVER['REQUEST_METHOD'] == 'DELETE'){http_response_code(400);}
            
        }
        return $output;
    }
}
?>