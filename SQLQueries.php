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
            return $pdo->query($sql);
        } catch (Exception $ex) {
            print($ex->getMessage());
        }
    }

    public static function getAllBars() {
        require 'connectToDb.php';
        $sql = "SELECT * FROM business";
        try {
            return $pdo->query($sql);
        } catch (Exception $ex) {
            print($ex->getMessage());
        }
    }

    public static function getBarFromYelpID($yelpID) {
           require 'connectToDb.php';
        $sql = "SELECT * FROM business WHERE yelpID='$yelpID'";
        try {
            return $pdo->query($sql);
        } catch (Exception $ex) {
            print($ex->getMessage());
        }
    }

    public static function getBarFromPhone($phone) {
        //We need to make sure phone has no spaces, dashes, or paranthesis in it.
        $phone = str_replace(" ", "", $phone);
        $phone = str_replace("-", "", $phone);
        $phone = str_replace("(", "", $phone);
        $phone = str_replace(")", "", $phone);
        return getBarFrom("phone", $phone);
    }

    // This function will return all bars that match $name
    // Caution, this function is likely to return more than 1 bar.
    public static function getBarFromName($name) {
        return getBarFrom("name", $name);
    }

    public static function getBarFromBarID($id) {
        require 'connectToDb.php';
        $sql = "SELECT * FROM business WHERE id='$id'";
        try {
            return $pdo->query($sql);
        } catch (Exception $ex) {
            print($ex->getMessage());
        }
    }

    public static function sanatizeInput($input) {
        $input = trim($input);
        return $input;
    }

    public static function getHappyHoursForHappyHourID($id) {
        require 'connectToDb.php';
        $id = sanatizeInput($id);
        $sql = "SELECT * FROM happyhour WHERE id='$id'";
        try {
            return $pdo->query($sql);
        } catch (Exception $ex) {
            print($ex->getMessage());
        }
    }

    public static function getHappyHoursByBusinessID($id) {
        require 'connectToDb.php';
        $sql = "SELECT * FROM happyhour "
                . "WHERE barID='$id'";
        try {
            return $pdo->query($sql);
        } catch (Exception $ex) {
            print($ex->getMessage());
        }
    }

    public static function getHappyHoursByYelpID($yelpID) {
        require 'connectToDb.php';
        $sql = "SELECT * FROM happyhour, business "
                . "WHERE business.yelpID='$yelpID'"
                . " AND business.id = happyhour.barID";
        try {
            return $pdo->query($sql);
        } catch (Exception $ex) {
            print($ex->getMessage());
        }
    }

    public static function addUser($email, $password) {
        require 'connectToDb.php';
        $stmt = $pdo->prepare("INSERT INTO users (email, password) VALUES (:email, :password)");
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', passwordHash($password));
        $stmt->execute();
    }

    public static function addHappyHour($businessID, $dayOfTheWeek, $startTime, $endTime, $description) {
        require 'connectToDb.php';
        if (SQLQueries::getHappyHourID($businessID, $dayOfTheWeek, $startTime, $endTime, $description) != -1) {
            echo "Happy Hour already exists!";
            return;
        }
        $stmt = $pdo->prepare("INSERT INTO happyhour (dayOfTheWeek, timeStart, timeEnd, description, barID) VALUES "
                . "(:dayOfTheWeek, :timeStart, :timeEnd, :description, :barID)");
        $stmt->bindParam(':dayOfTheWeek', $dayOfTheWeek);
        $stmt->bindParam(':timeStart', $startTime);
        $stmt->bindParam(':timeEnd', $endTime);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':barID', $businessID);
        $stmt->execute();
        $happyHourID = SQLQueries::getHappyHourID($businessID, $dayOfTheWeek, $startTime, $endTime, $description);
        if ($happyHourID == -1) {
            echo "Error writing to database!";
            return;
        }
    }
    
        public static function addBar($yelpID, $name, $phone) {
        require 'connectToDb.php';
         if (SQLQueries::getBarFromYelpID($yelpID)->fetch()) {
            //echo "Happy Hour already exists!";
            return;
        }
        $stmt = $pdo->prepare("INSERT INTO business (yelpID, phone, name) VALUES "
                . "(:yelpID, :phone, :name)");
        $stmt->bindParam(':yelpID', $yelpID);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':name', $name);
        try {
             $stmt->execute();
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
       
    }

    private static function getHappyHourID($businessId, $dayOfTheWeek, $startTime, $endTime, $description) {
        require 'connectToDb.php';

        $happyHoursResults = SQLQueries::getHappyHoursByBusinessID($businessId);
        while ($happyHourRow = $happyHoursResults->fetch()) {
            if ($happyHourRow['dayOfTheWeek'] == $dayOfTheWeek &&
                    $happyHourRow['timeStart'] == $startTime &&
                    $happyHourRow['timeEnd'] == $endTime &&
                    $happyHourRow['description'] == $description) {
                return $happyHourRow['id'];
            }
        }
        // no happy hour found
        return -1;
    }

    public static function passwordHash($password) {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    public static function addBusiness($yelpId, $phone, $name) {
        require 'connectToDb.php';
        $stmt = $pdo->prepare("INSERT INTO business (yelpID, phone, name) VALUES (:yelpID, :phone, :name)");
        $stmt->bindParam(':yelpId', $yelpId);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':name', $name);
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
