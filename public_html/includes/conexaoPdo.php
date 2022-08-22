<?php
function conexao () {
$servername = "localhost";
$username = "epapodetarotcom_sistema";
$password = "r5cug6wdj7offsts3t";
$database = "epapodetarotcom_67674";
try {
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password,
    array(
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
      ));
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch(PDOException $e)
    {
        echo "Connection failed: " . $e->getMessage();
    }
    return $conn;
}