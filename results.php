<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Dont' Worry, Bar Happy</title>
        <meta name="BarHappy" content="Our Webpage">
        <link rel="stylesheet" href="css/styles.css">
    </head>

    <body>     
        <h1 class="logo">Don't Worry, Bar Happy!</h1>
        <div class="resultsBox">

        </div>

        <?php
        function dayName($dayId) {
            switch ($dayId) {
                case 0:
                    return "Sunday";
                case 1:
                    return "Monday";
                case 2:
                    return "Tuesday";
                case 3:
                    return "Wednesday";
                case 4:
                    return "Thursday";
                case 5:
                    return "Friday";
                case 6:
                    return "Saturday";
                default:
                    return "Error";
            }
        }
        if (isset($_GET['zip'])) {
            include 'SQLQueries.php';
            // eventually get a list of all yelp results
            $searchResults = SQLQueries::getAllBars();
           echo '<table id="resultsTable">';
            while ($row = $searchResults->fetch()) {
                ?>
            <tr>
                <td class="barName"><?= $row['name'] ?></td>
                <td class="barPhone"><?= $row['phone'] ?></td>
                <td class="happyhours">
                    <?php
                     $happyHourResults = SQLQueries::getHappyHoursByBusinessID($row['id']);
                     while ($happyHourRow = $happyHourResults->fetch()) {
                         echo "Time Start: $happyHourRow[timeStart]<br>";
                         echo "Time End: $happyHourRow[timeEnd]<br>";
                         echo "Happy Hour: $happyHourRow[description]<br>";
                         echo "Day: " . dayName($happyHourRow['dayOfTheWeek']);
                     } //end happy hour row whle
                    ?>
                </td>
                <td class="barEditLinks">
                    <a href="submit.php?barID=<?= $row['id']?>">Add Happy Hour!</a>
                </td>
            </tr>
            
            <?php
        } // end search results while loop
        echo '</table>';
    } else {
        echo "Error searching for bar, zip code not set.";
    }
    ?>

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
