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

                <section id='searchLibrary'>
                    <?php  if($_SESSION['isStaff'] === TRUE){   
                    
                    echo "<div>
                        <h2>Search for the author you wish to update</h2>
                        <form id='searchAuthorForm' method='post' action='mainPage.php'>
                            <label>Search database for author</label>
                            <input id='searchAuthor' name='searchAuthor' type='text'>

                            <input type='submit' name='searchAuthorSubmit' value='search'>
                        </form>                    
                    </div>";
                    }
                    ?>
                    <div>
                        <form id='seachBook' method='post' action='mainPage.php'>
                            <label for='searchDatabase'>Use the search field to look for a book</label>
                            <input id='searchDatabase' name='searchDatabase' type='text'>
                            <button class='searchButton' type='submit' name='searchBook' onclick='clearEventsInfo()'>Search Database</button>
                        </form>   
                    </div>
                </section>

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