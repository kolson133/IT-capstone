<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class SQLQueries {


    private static function getBarFrom($field, $input) {
        require 'connectToDb.php';
        $input = sanatizeInput($input);
        $sql = "SELECT * FROM business WHERE $field='$input'";
        try {
            return $pdo -> query($sql);    
        } catch (Exception $ex) {
            print($ex->getMessage());
        }
    }

    public static function getAllBars() {
        require 'connectToDb.php';
        $sql = "SELECT * FROM business";
        try {
            return $pdo -> query($sql);    
        } catch (Exception $ex) {
            print($ex->getMessage());
        }
        
    }
    public static function getBarFromYelpID($yelpID) {
       return getBarFrom("yelpID", $yelpID);
    }

    public static function getBarFromPhone($phone) {
        //We need to make sure phone has no spaces, dashes, or paranthesis in it.
        $phone = str_replace(" ","",$phone);
        $phone = str_replace("-","",$phone);
        $phone = str_replace("(","",$phone);
        $phone = str_replace(")","",$phone);
        return getBarFrom("phone", $phone);
    }
    
    // This function will return all bars that match $name
    // Caution, this function is likely to return more than 1 bar.
    public static function getBarFromName($name) {
        return getBarFrom("name", $name);
    }
    
    public static function sanatizeInput($input) {
        $input = trim($input);
        return $input;
    }
    
    public static function getHappyHoursForHappyHourID($id) {
        require 'connectToDb.php';
        $id = sanatizeInput($id);
        $sql = "SELECT * FROM happyhour WHERE $id='$id'";
        try {
            return $pdo -> query($sql);    
        } catch (Exception $ex) {
            print($ex->getMessage());
        }
    }
    
    public static function getHappyHoursByBusinessID($id) {
        require 'connectToDb.php';
        $sql = "SELECT business.id, dayOfTheWeek, timeStart, timeEnd, happyhour.description "
                . "FROM userSubmissions, happyhour, business "
                . "WHERE userSubmissions.businessID = '$id'"
                . " AND userSubmissions.businessID = business.id"
                . " AND happyhour.id = userSubmissions.submissionID"
                . " AND userSubmissions.submissionType = '1'";
        try {
            return $pdo -> query($sql);    
        } catch (Exception $ex) {
            print($ex->getMessage());
        }
    }
    
    public static function passwordHash($password) {
        return password_hash($password, PASSWORD_DEFAULT);
    }
    
    public static function addUser($email, $password) {
        require 'connectToDb.php';
        $stmt = $pdo->prepare("INSERT INTO users (email, password) VALUES (:email, :password)");
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', passwordHash($password));
        $stmt->execute();
    }
    
    public static function userExists($email) {
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
    
    public static function getUserByEmail($email) {
         require 'connectToDb.php';
        try {
            $sql = "SELECT COUNT(email) FROM users"
                    . " WHERE email = '$email'";
            
            return $pdo->query($sql)->fetchColumn();
        } catch (Exception $ex) {
            print($ex->getMessage());
        }
    }
    
    public static function passwordMatches($email, $password) {
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
