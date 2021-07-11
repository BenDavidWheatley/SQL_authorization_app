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

    <body class='bodyImage'>
        <div class='pageContainer'>
            <div class='mainContainer'>       
                <header>
                    <?php include('header.php')?>
                <header>
                
                <section id='searchLibrary'>
                        <div class='searchDatabaseContainer'>
                            <form class='searchDatabase' method='post'>
                                <input  name='searchDatabase' type='text' placeholder='search for a book'>
                                <button  type='submit' name='searchBook' ><img src='assets/header-logos/searchIcon.png'></button>
                            </form>
                            <?php  if($_SESSION['isStaff'] === TRUE){                          
                        echo "
                                <div class='spacer'>
                                </div>
                            <form class='searchDatabase' method='post'>   
                                <input id='searchAuthor' name='searchAuthor' type='text' placeholder='search for an author'>
                                <button type='submit' name='searchAuthorSubmit' value='search'><img src='assets/header-logos/searchIcon.png'></button>     
                            </form>                                         
                        ";
                        }?>
                        </div>
                    </section>
                    <?php include('search.php'); ?>
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
                
                <footer class='footer' id='footerContainer'>
                    <?php include('footer.php') ?>
                </footer>
                <script src='script/script.js'></script>
            </div>
        </div>
    </body> 
</html>