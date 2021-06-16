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
            <div>
                <form method='POST'>
                    <label for='resetEmail'>Enter email Address</label>
                    <input type='text' name='resetEmail'>

                    <input type='submit' name='requestPassword'>
                </form>
                    <a href='index.php'><button>Back to login</button></a>
            </div>
    
            
           
            <footer>
                <?php include('footer.php') ?>
            </footer>
        </div>
        <script src='script/script.js'></script>

    </body> 
</html>