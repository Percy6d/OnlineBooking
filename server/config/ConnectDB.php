<?php

class ConnectDB
{
  private $host;
  private $username;
  private $password;
  private $database;
  private $connection;

  function __construct(){
    $host = "localhost";
    if($_SERVER['HTTP_HOST'] !== "localhost"){
      // Ignore this - It's for online hosting
      $username = "tomptlge_user";
      $password = "TomRuNek2022?";
      $database = "tomptlge_joeldim_db";
    }
    else {
      $username = "root";
      $password = "";
      $database = "josh_online_booking_project";
    }

    $this->host = $host;
    $this->username = $username;
    $this->password = $password;
    $this->database = $database;
  }

  function connect()
  {
    try {
      $this->connection = new PDO("mysql:host={$this->host};dbname={$this->database}", $this->username, $this->password);
      $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
      $this->connection = null;
      echo "Connection failed: {$e->getMessage()}";
    }
    return $this->connection;
  }
}

?>