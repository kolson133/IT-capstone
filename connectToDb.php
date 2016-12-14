<?php

/*
 * Connect to the DB server and select our DB
 */

try {
    
    // create an instance of the PDO class
    $pdo = new PDO('mysql:host=localhost:3306;dbname=dwbh', 'dwbhuser', 'dwbh152a');
    
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec('SET NAMES utf8');
    
} catch (Exception $ex) {
    $errorMsg = "Unable to connect to the database Server: ". $ex ->getMessage();
    echo "$errorMsg";
    exit();
}

