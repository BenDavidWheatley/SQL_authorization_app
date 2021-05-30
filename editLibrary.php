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
            <div class='mainContainer'> 
                <header>
                    <?php include('header.php')?>
                <header>
            
                <section id='searchAuthorContainer'>
                    <div>
                        <h2>Seacrh for the author you wish to update</h2>
                        <form id='searchAuthorForm' method='post'>
                            <label>Search database for author</label>
                            <input id='searchAuthor' name='searchAuthor' type='text'>

                            <input type='submit' name='searchAuthorSubmit' value='search'>
                        </form>                    
                    </div>

                    <div>
                    <?php 
                        if(isset($_POST['searchAuthorSubmit'])){
                            $newAuthor->searchAuthor();               
                        }; 
                        if (isset($_POST['viewBooks'])){
                            $newAuthor->viewAuthorsBooks();
                        }; 
                        if(isset($_POST['submitAuthor'])){
                           $newAuthor->addAuthorToDatabase();
                        };                 
                        ?>
                    </div>
                </section>

                <section id='bookAuthorForms'>             
                    <?php                    
                        if(isset($_POST['addBookToDatabase'])){
                            $newAuthor->addBookForm();
                        };
                        if (isset($_POST['submitBook'])){
                            $newAuthor->addBookToDatabase();
                        };?>         
                </section>

                <section>
                    <div id=searchBook>
                        <form method='post'>
                            <label for='searchDatabase'>Search Book</label>
                            <input id='searchDatabase' name='searchDatabase' type='text'>
                            <button type='submit' name='searchBook'>Search Database</button>
                        </form>           
                    </div>
                    <div>
                        <?php 
                            if (isset($_POST['searchBook'])) {
                                $newAuthor->searchBook();                    
                            }; ?>
                    </div>
                    <div id='editContainer'>
                        <?php
                            if (isset($_POST['edit'])){
                                $newAuthor->editBook();
                            }
                            if (isset($_POST['editSubmit'])){
                                $newAuthor->submitEdit();
                            }
                            if (isset($_POST['deleteBook'])){
                                $newAuthor->deleteBookWarning(); 
                            }
                            if (isset($_POST['confirmDeleteBook'])){
                                $newAuthor->deleteBookFromDatabase();
                            }?>
                    </div>
                </section>
            </div> 
        
            <footer>
                <?php include('footer.php') ?>
            </footer>
        </div>
        <script src='script/script.js'></script>

    </body> 
</html>