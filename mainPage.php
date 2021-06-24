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
                 <?php  if ($_SESSION['isStaff'] === FALSE) {
                }?>

                    <section id='searchLibrary'>
                        <?php  if($_SESSION['isStaff'] === TRUE){   
                        
                        echo "<div>
                            <h2>Seacrh for the author you wish to update</h2>
                            <form id='searchAuthorForm' method='post'>
                                <label>Search database for author</label>
                                <input id='searchAuthor' name='searchAuthor' type='text'>

                                <input type='submit' name='searchAuthorSubmit' value='search'>
                            </form>                    
                        </div>";
                        }
                        ?>
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
                            if (isset($_POST['searchAuthorSubmit'])){
                                $newEntry->searchAuthor();
                            }
                            if(isset($_POST['searchBook'])){
                                $newEntry->searchBook();
                            }
                            if (isset($_POST['addToCart'])){
                                $newEntry->addToCart();  
                                                                                                              
                            }
                            if (isset($_POST['checkIn'])){
                                $newEntry->bookCheckin();
                            }
                            if (isset($_POST['viewBooks'])){
                                $newEntry->viewAuthorsBooks();
                            };  
                            
                           
                            if (isset($_POST['sortByIdAsc'])){
                                $_SESSION['sortBy'] = 'book_id';
                                $newEntry->sortAscending();
                            }else if (isset($_POST['sortByTitleAsc'])){
                                $_SESSION['sortBy'] = 'book_title';
                                $newEntry->sortAscending();
                            }else if(isset($_POST['sortByAuthorAsc'])){
                                $_SESSION['sortBy'] = 'author_name';
                                $newEntry->sortAscending();
                            }else if(isset($_POST['sortByYearAsc'])){
                                $_SESSION['sortBy'] = 'year_released';
                                $newEntry->sortAscending();
                            }else if(isset($_POST['sortByGenreAsc'])){
                                $_SESSION['sortBy'] = 'book_genre';
                                $newEntry->sortAscending();
                            }else if(isset($_POST['sortByAgeAsc'])){
                                $_SESSION['sortBy'] = 'age_group';                            
                                $newEntry->sortAscending();
                            }else if(isset($_POST['sortByCheckedOutAsc'])){
                                $_SESSION['sortBy'] = 'is_checked_out';
                                $newEntry->sortAscending();
                            }else if (isset($_POST['sortByIdDesc'])){
                                $_SESSION['sortBy'] = 'book_id';
                                $newEntry->sortDescending();
                            }else if (isset($_POST['sortByTitleDesc'])){
                                $_SESSION['sortBy'] = 'book_title';
                                $newEntry->sortDescending();
                            }else if(isset($_POST['sortByAuthorDesc'])){
                                $_SESSION['sortBy'] = 'author_name';
                                $newEntry->sortDescending();
                            }else if(isset($_POST['sortByYearDesc'])){
                                $_SESSION['sortBy'] = 'year_released';
                                $newEntry->sortDescending();
                            }else if(isset($_POST['sortByGenreDesc'])){
                                $_SESSION['sortBy'] = 'book_genre';
                                $newEntry->sortDescending();
                            }else if(isset($_POST['sortByAgeDesc'])){
                                $_SESSION['sortBy'] = 'age_group';
                                $newEntry->sortDescending();
                            }else if(isset($_POST['sortByCheckedOutDesc'])){
                                $_SESSION['sortBy'] = 'is_checked_out';
                                $newEntry->sortDescending();
                            }                       
                        ?>
                            
                    </section>
                <footer>
                    <?php include('footer.php') ?>
                </footer>
            </div>
        </div>

        <script src='script/script.js'></script> 
    </body> 
</html>