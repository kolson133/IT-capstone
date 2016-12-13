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
        if (isset($_POST['submit'])) {
            //process form input
            
            


            $barID = $_POST['barID'];
            if (!$barID) {
                echo "<center>Thank you for your submission!\n<br> Since this is a new bar, your submission has been emailed.</center>";
                return;
            } else {
                echo "<center>Thank you for your submission!</center>";
            }
            if(!isset($_POST['dayOfWeek']) || !isset($_POST['startTime']) || !isset($_POST['endTime']) || !isset($_POST['details'])) {
                die("Please enter all fields!");
            }
            $dayOfWeek = $_POST['dayOfWeek'];
            $startTime = $_POST['startTime'];
            $endTime = $_POST['endTime'];
            $details = $_POST['details'];

            function dayOfWeek($day) {
                switch ($day) {
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
            if($dayOfWeek == 7) {
                die("Please enter in a valid day of the week!");
            }
            if(!is_numeric($barID)) {
                die("Error, invalid form data entered for bar id.");
            }
            function verifyValidTime($time) {
                return preg_match("/[0-9]{1,2}:[0-9]{2}/", $time);
            }
            if(!verifyValidTime($startTime) || !verifyValidTime($endTime)) {
                die("Please enter a valid start and end time.");
            }
            if($details == "") {
                die("Please enter valid details!");
            }
            include 'SQLQueries.php';
            SQLQueries::addHappyHour($barID, $dayOfWeek, $startTime, $endTime, $details);
            
        } else {
            ?>

            <form class="form-basic" method="post" action="#">

                <div class="form-title-row">
                    <h1 class="formH1">New Happy Hour Form</h1>
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
                if (isset($_GET['barID'])) {
                    $barID = $_GET['barID'];
                    $phone = $_GET['barPhone'];
                    $name = $_GET['barName'];
                    $yelpID = $_GET['barYelpID'];
                    $disabled = " disabled";
                    require 'connectToDb.php';
                    include 'SQLQueries.php';
                    try {
                        if ($barID == -1) {
                            echo "Adding bar to database";
                            $phoneString = substr($phone, 3);
                            $phoneString = str_replace("-", "", $phoneString);
                            try {
                                SQLQueries::addBar($yelpID, $name, $phoneString);
                            } catch (Exception $ex) {
                                echo "error while getting bar name";
                                echo $ex->getMessage();
                            }
                            $barResults = SQLQueries::getBarFromYelpID($yelpID);
                        } else {
                            $barResults = SQLQueries::getBarFromBarID($barID);
                        }
                        $row = $barResults->fetch();
                        if($barID == -1) {
                            $barID = $row['id'];
                        }
                        $barName = $name;
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
                        <select name="dayOfWeek" required>
                            <option value="Sunday">Sunday</option>
                            <option value="Monday">Monday</option>
                            <option value="Tuesday">Tuesday</option>
                            <option value="Wednesday">Wednesday</option>
                            <option value="Thursday">Thursday</option>
                            <option value="Friday">Friday</option>
                            <option value="Saturday">Saturday</option>
                        </select>
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

                <br><br><br><br><br><br><br><br>
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
