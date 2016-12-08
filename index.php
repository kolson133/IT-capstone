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
        <div class="searchBox"><br><br><br>
            <center>
                <p>Enter Zip Code</p>
                <form  method="get" action="results.php"  id="searchform"> 
                    <input id="zip" type="number" name="zip" required><br><br>
                <input  type="submit" name="submit" value="Search"> 
                </form>
            </center>   
        </div>
        
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

