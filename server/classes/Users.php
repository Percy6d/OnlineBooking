<?php
// Getting all required files
require_once("../../config/uidGenerator.php");
require_once("../../config/passwordSecured.php");
require_once("../../config/datetimeGenerator.php");
require_once("../../config/MyJWT.php");
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
                $lastInsertedID = $this->conn->lastInsertId();
                $tokenizedData = new stdClass();
                $tokenizedData->id = $lastInsertedID;
                $tokenizedData->emailAddress = $objEmailAddress;
                $jwt = new MyJWT();
                $jwtEncode = $jwt->encode("users", $tokenizedData);
                $jwtEncode["message"] = "New user added";
                $output = $jwtEncode;
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
    function authUser($obj){
        $passwordSecured = new PasswordSecured();
        if(isset($obj->emailAddress)){
            $objEmailAddress = trim(strtolower($obj->emailAddress));
        } else {
            if($_SERVER['REQUEST_METHOD'] == 'GET' || $_SERVER['REQUEST_METHOD'] == 'POST'){http_response_code(406);}
            exit("No emailAddress property was found in your object");
        }
        if(!isset($obj->password)){
            if($_SERVER['REQUEST_METHOD'] == 'GET' || $_SERVER['REQUEST_METHOD'] == 'POST'){http_response_code(406);}
            exit("No password property was found in your object");
        }
        try
        {
            $query = $this->conn->prepare("SELECT uid, emailAddress, password, isVerified FROM users WHERE emailAddress = :emailAddress");
            $query->bindParam(":emailAddress", $objEmailAddress);
            if($query->execute()){
                if($query->rowCount() > 0){
                    $result = $query->fetch(PDO::FETCH_ASSOC);
                    $jwt = new MyJWT();
                    $hashedPassword = $result["password"];
                    $verifyPassword = $passwordSecured->verify($obj->password, $hashedPassword);
                    if($verifyPassword){
                        if((int)$result["isVerified"] == 1){
                            $result["isVerified"] = true;
                        } else {
                            $result["isVerified"] = false;
                        }
                        $jwtEncode = $jwt->encode("users", $result);
                        $jwtEncode["message"] = "Logged in successfully!";
                        $output = $jwtEncode;
                        if($_SERVER['REQUEST_METHOD'] == 'GET' || $_SERVER['REQUEST_METHOD'] == 'POST'){http_response_code(202);}
                    }
                    else {
                        $output = "Incorrect password";
                        if($_SERVER['REQUEST_METHOD'] == 'GET' || $_SERVER['REQUEST_METHOD'] == 'POST'){
                            if($_SERVER['REQUEST_METHOD'] == 'GET' || $_SERVER['REQUEST_METHOD'] == 'POST'){http_response_code(401);}
                        }
                        
                    }
                }
                else {
                    $output = "No mobile number found!";
                    if($_SERVER['REQUEST_METHOD'] == 'GET' || $_SERVER['REQUEST_METHOD'] == 'POST'){
                        if($_SERVER['REQUEST_METHOD'] == 'GET' || $_SERVER['REQUEST_METHOD'] == 'POST'){http_response_code(401);}
                    }
                }
            }
            else {
                $output = "Something went wrong!";
                if($_SERVER['REQUEST_METHOD'] == 'GET' || $_SERVER['REQUEST_METHOD'] == 'POST'){
                    if($_SERVER['REQUEST_METHOD'] == 'GET' || $_SERVER['REQUEST_METHOD'] == 'POST'){http_response_code(400);}
                }
                
            }
        }
        catch (PDOException $e)
        {
            $output = "Query Failed: {$e->getMessage()}";
            if($_SERVER['REQUEST_METHOD'] == 'GET' || $_SERVER['REQUEST_METHOD'] == 'POST'){
                if($_SERVER['REQUEST_METHOD'] == 'GET' || $_SERVER['REQUEST_METHOD'] == 'POST'){http_response_code(400);}
            }
            
        }
        return $output;
    }
}
?>