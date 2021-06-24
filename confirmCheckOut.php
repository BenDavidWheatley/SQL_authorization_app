<?php 
session_start();
include('membersClassOOP.php');
include('libraryClassOOP.php');
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
        <div class='pageContainer'>
            <div class='mainContainer'>       
                <header>
                    <?php include('header.php')?>
                <header>

                <div>
                    <p>Thank you for checkin out - </p>
                    <?php $newEntry->confirmedCheckOut() ?>
                    <p>We hope that you enjoy your reads</p>
                </div>
                           
                <footer>
                    <?php include('footer.php') ?>
                </footer>
                <script src='script/script.js'></script>

            </div>
        </div>

    </body> 
</html>