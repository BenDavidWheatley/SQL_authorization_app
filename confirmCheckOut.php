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
        <header>
             <?php include('header.php')?>
        </header>
            <section id='searchLibrary'>
                    <div class='searchDatabaseContainer'>
                        <form class='searchDatabase' method='post'>
                            <input  name='searchDatabase' type='text' placeholder='search for a book'>
                            <button  type='submit' name='searchBook' ><img src='assets/header-logos/searchIcon.png'></button>
                        </form>
                        <?php  if($_SESSION['isStaff'] === TRUE){                          
                            echo "
                                <form class='searchDatabase' method='post'>   
                                    <input id='searchAuthor' name='searchAuthor' type='text' placeholder='search for an author'>
                                    <button type='submit' name='searchAuthorSubmit' value='search'><img src='assets/header-logos/searchIcon.png'></button>     
                                </form>                                         
                            ";
                        }?>
                        
                    </div>
                    
                <div>                 
                    <?php $newEntry->confirmedCheckOut() ?>                 
                </div>
            </section>
        <footer class='footer' id='footerContainer'>
                    <?php include('footer.php') ?>
        </footer>
        <script src='script/script.js'></script>
    </body> 
</html>