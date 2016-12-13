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
            $zip = $_GET['zip'];
            include 'SQLQueries.php';
            include './yelp.php';
            $searchResults = query_api($zip);
            echo '<table id="resultsTable">';
            foreach ($searchResults as $bar) {
                // We are only showing bars with phone numbers
                if (isset($bar->display_phone)) {
                    $yelpID = $bar->id;
                    $phone = $bar->display_phone;
                    $name = $bar->name;
                } else {
                    continue;
                }
                ?>
            <tr>
                <td class="barName"><?= $name ?></td>
                <td class="barPhone"><?= $phone ?></td>
                <td class="happyhours">
                    <?php
                    $barID = -1;
                    $barResults = SQLQueries::getBarFromYelpID($yelpID);
                    while($barResultsRow = $barResults->fetch()) {
                        $barID = $barResultsRow['id'];
                    }
                    $happyHourResults = SQLQueries::getHappyHoursByYelpID($yelpID);
                    while ($happyHourRow = $happyHourResults->fetch()) {
                        echo "Happy Hour: $happyHourRow[description]<br>";
                        echo "Time Start: $happyHourRow[timeStart]<br>";
                        echo "Time End: $happyHourRow[timeEnd]<br>";
                        echo "Day: " . dayName($happyHourRow['dayOfTheWeek']);
                        
                        $barID = $happyHourRow['barID'];
                        echo "<br><br>";
                    } //end happy hour row whle
                    ?>
                </td>
                <td class="barEditLinks">
                    <form action="submit.php" method="get">
                        <input type="hidden" name="barID" value="<?= $barID ?>">
                        <input type="hidden" name="barName" value="<?= $name ?>">
                        <input type="hidden" name="barPhone" value="<?= $phone ?>">
                        <input type="hidden" name="barYelpID" value="<?= $yelpID ?>">
                        <input type="submit" value="Add Happy Hour!">
                    </form>
                    
                    <?php $barID = -1; ?>
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
