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
                    <p>THIS IS THE MAIN PAGE</p>
                    <section id='searchLibrary'>
                        <div>
                            <form method='post'>
                                <label for='searchDatabase'>Search Book</label>
                                <input id='searchDatabase' name='searchDatabase' type='text'>
                                <button type='submit' name='searchBook'>Search Database</button>
                            </form>   
                        </div>
                    </section>
                    <section>
                        <?php 
                            if(isset($_POST['searchBook'])){
                                $newAuthor->searchBook();
                            } ?>
                    </section>
                   

                    

                <footer>
                    <?php include('footer.php') ?>
                </footer>
            </div>
        </div>

        <script src='script/script.js'></script>
    </body> 
</html>