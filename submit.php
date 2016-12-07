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
        
<form class="form-basic" method="post" action="#">

            <div class="form-title-row">
                <h1 class="formH1">New Bar Form</h1>
            </div>

            <div class="form-row">
                <label>
                    <span>Full name</span>
                    <input type="text" name="name">
                </label>
            </div>

            <div class="form-row">
                <label>
                    <span>Email</span>
                    <input type="email" name="email">
                </label>
            </div>
    
            <div class="form-row">
                <label>
                    <span>Bar Name</span>
                    <input type="barName" name="bar">
                </label>
            </div>
    
            <div class="form-row">
                <label>
                    <span>Happy Hour Times</span>
                    <input list="happyHour" name="happyHour">
                      <datalist id="happyHour">
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
                    <span>Details</span>
                    <textarea name="textarea"></textarea>
                </label>
            </div>

            <div class="form-row">
                <button type="submit">Submit Bar</button>
            </div>

</form><br><br><br><br><br><br><br><br>
        <footer>
            <div class="nav">
                <ul>
                    <li><a class="links" href="contact.php">Contact Us</a></li>
                    <li><a class="links" href="index.php">Home</a></li>
                    <li><a class="links" href="submit.php">Submit</a></li>
                </ul>
            </div>
        </footer>
    </body>
</html>
