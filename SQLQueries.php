<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class SQLQueries {


    private function getBarFrom($field, $input) {
        require 'connectToDb.php';
        $input = sanatizeInput($input);
        $sql = "SELECT * FROM business WHERE $field='$input'";
        try {
            return $pdo -> query($sql);    
        } catch (Exception $ex) {
            print($ex->getMessage());
        }
    }

    public function getBarFromYelpID($yelpID) {
       return getBarFrom("yelpID", $yelpID);
    }

    public function getBarFromPhone($phone) {
        //We need to make sure phone has no spaces, dashes, or paranthesis in it.
        $phone = str_replace(" ","",$phone);
        $phone = str_replace("-","",$phone);
        $phone = str_replace("(","",$phone);
        $phone = str_replace(")","",$phone);
        return getBarFrom("phone", $phone);
    }
    
    // This function will return all bars that match $name
    // Caution, this function is likely to return more than 1 bar.
    public function getBarFromName($name) {
        return getBarFrom("name", $name);
    }
    
    public function sanatizeInput($input) {
        $input = trim($input);
        return $input;
    }
    
    public function getHappyHoursForHappyHourID($id) {
        require 'connectToDb.php';
        $id = sanatizeInput($id);
        $sql = "SELECT * FROM happyhour WHERE $id='$id'";
        try {
            return $pdo -> query($sql);    
        } catch (Exception $ex) {
            print($ex->getMessage());
        }
    }
    
    public function getHappyHoursByBusinessID($id) {
        require 'connectToDb.php';
        $sql = "SELECT business.id, dayOfTheWeek, timeStart, timeEnd, happyhour.description "
                . "FROM userSubmissions, happyhour, business "
                . "WHERE userSubmissions.businessID = business.id";
        try {
            return $pdo -> query($sql);    
        } catch (Exception $ex) {
            print($ex->getMessage());
        }
    }
    
    public function passwordHash($password) {
        return password_hash($password, PASSWORD_DEFAULT);
    }
    
    public function addUser($email, $password) {
        require 'connectToDb.php';
        $stmt = $pdo->prepare("INSERT INTO users (email, password) VALUES (:email, :password)");
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', passwordHash($password));
        $stmt->execute();
    }
    
    public function userExists($email) {
        require 'connectToDb.php';
        try {
            $sql = "SELECT COUNT(email) FROM users"
                    . " WHERE email = '$email'";
            
            return $pdo->query($sql)->fetchColumn();
        } catch (Exception $ex) {
            print($ex->getMessage());
        }
        return false;
    }
    
    public function getUserByEmail($email) {
         require 'connectToDb.php';
        try {
            $sql = "SELECT COUNT(email) FROM users"
                    . " WHERE email = '$email'";
            
            return $pdo->query($sql)->fetchColumn();
        } catch (Exception $ex) {
            print($ex->getMessage());
        }
    }
    
    public function passwordMatches($email, $password) {
        require 'connectToDb.php';
        try {
            $sql = "SELECT * FROM users"
                    . " WHERE email = '$email'";
            
            $row = $pdo->query($sql)->fetch();
            return password_verify($password, $row['password']);
        } catch (Exception $ex) {
            print($ex->getMessage());
        }
        
    }

}
