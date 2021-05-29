<?php session_start(); 
include('function.php');
?>

<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="style/style.css" type="text/css">
        <title>Library App - New Member</title>
    </head>

    <body>
        <div class='pageContainer'>
            <div CLASS='mainContainer'>       
                <header>
                    <?php include('header.php')?>
                <header>

                <section>
                    <h2>New Account Created</h2>
                    <p>Thank you <?php $newUser->getFullName() ?> for creating a new account</p>
                    <p>You're new username is - <?php $newUser->getUserName() ?></p>
                    <p>An email confirming you're password has been sent to <?php $newUser->getEmail()?></p>
                    <p>Please go back to the login page to continue on to the site</p>
                    <button onclick="window.location.href='index.php'">Return to login</button>
                </section>
                <footer>
                    <?php include('footer.php')?>
                </footer>
            </div>
        </div>
        <script src='script/script.js'></script>
    </body>
</html>