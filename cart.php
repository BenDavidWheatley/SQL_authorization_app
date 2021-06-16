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
                    <?php 
                        if(isset($_POST['checkout'])){
                            $newEntry->checkout();
                        }
                        if(isset($_POST['removeFromCart'])){
                            $newEntry->removeFromCart();
                        }   ?>
                </div>

                <div>
                    <?php $newEntry->cart(); ?>
                </div>
            
                <form id='checkOut' method='POST' >
                    <button id='checkout' name='checkout' >Checkout</button>
                </form>
                
                <footer>
                    <?php include('footer.php') ?>
                </footer>
                <script src='script/script.js'></script>

            </div>
        </div>

    </body> 
</html>