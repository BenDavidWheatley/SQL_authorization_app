<?php 
session_start();
include('membersClassOOP.php');
include('login.php');
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
        <div class='mainContainer'>
            <div class='pageContainer'>
                <header>
                    <?php include('header.php')?>
                <header>
                
                <footer>
                    <?php include('footer.php')?>
                </footer>

                <script src='script/script.js'></script>
            </div>
        </div>
    </body>  
</html>