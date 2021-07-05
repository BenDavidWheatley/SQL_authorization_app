<?php 
session_start();
include('membersClassOOP.php');
include('libraryClassOOP.php');
include('login.php');
include('connect.php');
$mysqli->query($sql);
?>

<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="style/style.css" type="text/css">
        <title>Library App</title>
    </head>

    <body>
   
        <div class='pageContainer'>  
            <div class='container forgotContainer'>
                <h1>Reset your password</h1>
                <p>An email will be sent to you with instruction on how to reset your password</p>
                <form action='reset.php' method='POST'>
                    <label class='label' for='resetEmail'>Enter email Address</label>
                    <input class='forgotInput' type='text' name='resetEmail' placeholder="Enter your email address">

                    <button class='loginButtons' type='submit' name='requestRequestSubmit'>Recieve new password by email</button>
                </form>

                <?php 
                    if(isset($_GET['reset'])){
                        if($_GET['reset'] === 'success'){
                            echo "<p class='signUpSuccess'>Check your email</p>";
                        }
                    }
                ?>
                    <a href='index.php'><button class='loginButtons'>Back to login</button></a>
            </div>
    
            
           
            <footer>
                <?php include('footer.php') ?>
            </footer>
        </div>
        <script src='script/script.js'></script>

    </body> 
</html>