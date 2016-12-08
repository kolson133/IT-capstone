<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Dont' Worry, Bar Happy</title>
        <meta name="BarHappy" content="submitBar">
        <link rel="stylesheet" href="css/styles.css">
    </head>
    
    <body>     
        <h1 class="logo">Don't Worry, Bar Happy!</h1>
        
        <?php
        if(isset($_POST['submit'])) {
            //process form input
            echo "Thank you for your submission!";
            $barID = $_POST['barID'];
            $dayOfWeek = $_POST['dayOfWeek'];
            $startTime = $_POST['startTime'];
            $endTime = $_POST['endTime'];
            $details = $_POST['details'];
            
            function dayOfWeek($day) {
                switch($day) {
                    case "Sunday":
                        return 0;
                    case "Monday":
                        return 1;
                    case "Tuesday":
                        return 2;
                    case "Wednesday":
                        return 3;
                    case "Thursday":
                        return 4;
                    case "Friday":
                        return 5;
                    case "Saturday":
                        return 6;
                    default:
                        return 7;
                }
            }
            $dayOfWeek = dayOfWeek($dayOfWeek);
            include 'SQLQueries.php';
            SQLQueries::addHappyHour($barID, $dayOfWeek, $startTime, $endTime, $details);
        } else {
        ?>
        
<form class="form-basic" method="post" action="#">

            <div class="form-title-row">
                <h1 class="formH1">New Bar Form</h1>
            </div>

            <div class="form-row">
                <label>
                    <span>Full name</span>
                    <input type="text" name="name" required>
                </label>
            </div>

            <div class="form-row">
                <label>
                    <span>Email</span>
                    <input type="email" name="email" required>
                </label>
            </div>
    
            <?php
                $disabled = "";
                $barName = "";
                $barID = "";
                if(isset($_GET['barID'])) {
                    $barID = $_GET['barID'];
                    $disabled = " disabled";
                    require 'connectToDb.php';
                    include 'SQLQueries.php';
                    try {
                         $barResults = SQLQueries::getBarFromBarID($barID);
                    $row = $barResults ->fetch();
                    $barName = $row['name'];
                    } catch (Exception $ex) {
                        echo "error while getting bar name";
                        echo $ex->getMessage();
                    }
                   
                }
             
            ?>
            <div class="form-row">
                <label>
                    <span>Bar Name</span>
                    <input type="text" name="bar" <?= $disabled ?> value="<?= $barName ?>" required>
                </label>
            </div>
    
            <div class="form-row">
                <label>
                    <span>Happy Hour Day</span>
                    <input list="dayOfWeek" name="dayOfWeek" required>
                      <datalist id="dayOfWeek">
                        <option value="Sunday">
                        <option value="Monday">
                        <option value="Tuesday">
                        <option value="Wednesday">
                        <option value="Thursday">
                        <option value="Friday">
                        <option value="Saturday">
                      </datalist>
                </label>
            </div>
    
                <div class="form-row">
                <label>
                    <span>Start Time</span>
                    <input type="text" name="startTime" value="08:00" required>
                </label>
            </div>
    
                <div class="form-row">
                <label>
                    <span>End Time</span>
                    <input type="text" name="endTime" value="20:00" required>
                </label>
            </div>

            <div class="form-row">
                <label>
                    <span>Details</span>
                    <textarea name="details" required></textarea>
                </label>
            </div>

            <div class="form-row">
                <button name="submit" type="submit">Submit Bar</button>
            </div>
            <input type="hidden" name="barID" value="<?= $barID ?>">
</form>
        
        <?php
        } //end if post submitted
        ?>
        <br><br><br><br><br><br><br><br>
        <footer>
            <div class="nav">
                <ul>
                    <li><a class="links" href="contact.php">Contact</a></li>
                    <li><a class="links" href="index.php">Home</a></li>
                    <li><a class="links" href="submit.php">Submit</a></li>
                </ul>
            </div>
        </footer>
    </body>
</html>
