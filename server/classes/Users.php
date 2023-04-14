<?php
// Getting all required files
require_once("../../config/uidGenerator.php");
require_once("../../config/passwordSecured.php");
require_once("../../config/datetimeGenerator.php");
// require_once("../../config/MyJWT.php");
// require_once("../../config/customMail.php");
require_once("../../config/ConnectDB.php");
class Users {
    public $conn;
    public $connectDB;
    function __construct(){
        $connectDB = new ConnectDB();
        $this->connectDB = $connectDB;
        $this->conn = $connectDB->connect();
    }
    function newUser($obj){
        $generatedUID = new UIDGenerator();
        $passwordSecured = new PasswordSecured();
        $dateTimeGenerate = new DateTimeGenerator();
        $uid = $generatedUID->getUID(20, null);
        $dateTimeUTC = $dateTimeGenerate->toUTC();
        
        if(isset($obj->emailAddress)){
            $objEmailAddress = trim(strtolower($obj->emailAddress));
        } else {
            if($_SERVER['REQUEST_METHOD'] == 'GET' || $_SERVER['REQUEST_METHOD'] == 'POST'){http_response_code(406);}
            exit("No emailAddress property was found in your object");
        }
        if(isset($obj->password)){
            $password = $obj->password;
            $passwordHashed = $passwordSecured->hash($password);
        } else {
            if($_SERVER['REQUEST_METHOD'] == 'GET' || $_SERVER['REQUEST_METHOD'] == 'POST'){http_response_code(406);}
            exit("No password property was found in your object");
        }
        try {
            $query = $this->conn->prepare("INSERT INTO users (uid, emailAddress, password, timeCreated, timeUpdated) VALUES (:uid, :emailAddress, :password, :timeCreated, :timeUpdated)");
            $query->bindParam(":uid", $uid);
            $query->bindParam(":emailAddress", $objEmailAddress);
            $query->bindParam(":password", $passwordHashed);
            $query->bindParam(":timeCreated", $dateTimeUTC);
            $query->bindParam(":timeUpdated", $dateTimeUTC);
            if($query->execute()){
                $output = "New user added";
                if($_SERVER['REQUEST_METHOD'] == 'GET' || $_SERVER['REQUEST_METHOD'] == 'POST'){http_response_code(201);}
            }
            else {
                $output = "Something went wrong!";
                if($_SERVER['REQUEST_METHOD'] == 'GET' || $_SERVER['REQUEST_METHOD'] == 'POST'){http_response_code(400);}
                
            }
        } catch (PDOException $e) {
            $output = "Query Failed: {$e->getMessage()}";
            if($_SERVER['REQUEST_METHOD'] == 'GET' || $_SERVER['REQUEST_METHOD'] == 'POST'){http_response_code(400);}
            
        }
        return $output;
    }
}
?>