<?php

// Require vendor folder
require "../../vendor/autoload.php";
date_default_timezone_set('UTC');
use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;

class MyJWT {
    function encode($audience, $data){
        // Creating the payload
        $iss = "onlineBooking";
        $iat = time();
        $nbf = $iat + 5;
        $exp = $iat + (60*60*1);
        $aud = $audience;
        // Our secret key
        $secret_key = "#Default101#";
        // Setting payload
        $payload_info = array(
            "iss" => $iss,
            "iat" => $iat,
            "nbf" => $nbf,
            "exp" => $exp,
            "aud" => $aud,
            "data" => $data
        );
        $payload_info_refresh = array(
            "iss" => $iss,
            "iat" => $iat,
            "nbf" => $nbf,
            "exp" => $iat + (60*60*24*15),
            "aud" => "refreshers"
        );
        $accessJWT = JWT::encode($payload_info, $secret_key, "HS512");
        $refreshJWT = JWT::encode($payload_info_refresh, $secret_key, "HS512");
        $output = array(
            "access_token" => $accessJWT,
            "refresh_token" => $refreshJWT
        );
        if($_SERVER['REQUEST_METHOD'] == 'GET' || $_SERVER['REQUEST_METHOD'] == 'POST'){http_response_code(200);}
        return $output;
    }
    function decode(){
        $headers = getallheaders();
        $jwt = $headers['Authorization'];
        if(!empty($jwt)){
            try{
                $secret_key = "#Default101#";
                // Decoding JWT
                $decoded_data = JWT::decode($jwt, new Key($secret_key, 'HS512'));
                $output = $decoded_data;
                if($_SERVER['REQUEST_METHOD'] == 'GET' || $_SERVER['REQUEST_METHOD'] == 'POST'){http_response_code(202);}
            } catch(Exception $ex) {
                $output = $ex->getMessage();
                if($_SERVER['REQUEST_METHOD'] == 'GET' || $_SERVER['REQUEST_METHOD'] == 'POST'){http_response_code(401);}
            }
        }
        else {
            $output = "Invalid Authorization";
            if($_SERVER['REQUEST_METHOD'] == 'GET' || $_SERVER['REQUEST_METHOD'] == 'POST'){http_response_code(401);}
        }
        return $output;
    }
    function refresh($obj){
        $headers = getallheaders();
        $jwt = $headers['Authorization'];
        if(!empty($jwt)){
            $secret_key = "#Default101#";
            if(isset($obj->token)){
                try{
                    // Decoding JWT
                    $decoded = (array) JWT::decode($obj->token, new Key($secret_key, 'HS512'));
                    try {
                        $decoded = (array) JWT::decode($jwt, new Key($secret_key, 'HS512'));
                        $output = "Still in use";
                        if($_SERVER['REQUEST_METHOD'] == 'GET' || $_SERVER['REQUEST_METHOD'] == 'POST'){http_response_code(400);}
                    } catch(Exception $ex) {
                        if($ex->getMessage() == "Expired token"){
                            list($header, $payload, $signature) = explode(".", $jwt);
                            $payload = json_decode(base64_decode($payload));
                            $payload_info =array(
                                "iss"=>$payload->iss,
                                "iat"=>time(),
                                "nbf"=>$payload->nbf,
                                "exp"=>time() + (60*60*1),
                                "aud"=>$payload->aud,
                                "data"=>$payload->data
                            );
                            $payload_info_refresh = array(
                                "iss" => $payload->iss,
                                "iat" => time(),
                                "nbf" => $payload->nbf,
                                "exp" => time() + (60*60*24*15),
                                "aud" => "refreshers"
                            );
                            $accessJWT = JWT::encode($payload_info, $secret_key, "HS512");
                            $refreshJWT = JWT::encode($payload_info_refresh, $secret_key, "HS512");
                            $output = array(
                                "access_token" => $accessJWT,
                                "refresh_token" => $refreshJWT
                            );
                            if($_SERVER['REQUEST_METHOD'] == 'GET' || $_SERVER['REQUEST_METHOD'] == 'POST'){http_response_code(201);}
                        }
                        else {
                            $output = $ex->getMessage();
                            if($_SERVER['REQUEST_METHOD'] == 'GET' || $_SERVER['REQUEST_METHOD'] == 'POST'){http_response_code(401);}
                        }
                    }
                } catch(Exception $ex) {
                    $output = $ex->getMessage();
                    if($_SERVER['REQUEST_METHOD'] == 'GET' || $_SERVER['REQUEST_METHOD'] == 'POST'){http_response_code(401);}
                }
            }
            else {
                $output = "No token found";
                if($_SERVER['REQUEST_METHOD'] == 'GET' || $_SERVER['REQUEST_METHOD'] == 'POST'){http_response_code(401);}
            }
        }
        else {
            $output = "Invalid Authorization";
            if($_SERVER['REQUEST_METHOD'] == 'GET' || $_SERVER['REQUEST_METHOD'] == 'POST'){http_response_code(401);}
        }
        return $output;
    }
}

?>