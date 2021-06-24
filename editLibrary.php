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
                            $newEntry->searchAuthor();               
                        }; 
                        if(isset($_POST['editAuthor'])){
                            $newEntry->editAuthor();
                        }
                        if(isset($_POST['submitAuthorEdit'])){
                            $newEntry->submitAuthorEdit();
                        }
                        if (isset($_POST['viewBooks'])){
                            $newEntry->viewAuthorsBooks();
                        }; 
                        if(isset($_POST['deleteAuthor'])){
                            $newEntry->deleteAuthorWarning();
                        }
                        if(isset($_POST['confirmDeleteAuthor'])){
                            $newEntry->deleteAuthorFromDatabase();
                        }
                        if(isset($_POST['submitAuthor'])){
                           $newEntry->addAuthorToDatabase();
                        };   
                        if(isset($_POST['checkIn'])){
                            $newEntry->bookCheckin();
                        }              
                        ?>
                    </div>
                </section>

                <section id='bookAuthorForms'>             
                    <?php                    
                        if(isset($_POST['addBookToDatabase'])){
                            $newEntry->addBookForm();
                        };
                        if (isset($_POST['submitBook'])){
                            $newEntry->addBookToDatabase();
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
                                $newEntry->searchBook();                    
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
                    </div>
                    <div id='editContainer'>
                        <?php
                            if (isset($_POST['edit'])){
                                $newEntry->editBook();
                            }
                            if (isset($_POST['editSubmit'])){
                                $newEntry->submitEdit();
                            }
                            if (isset($_POST['deleteBook'])){
                                $newEntry->deleteBookWarning(); 
                            }
                            if (isset($_POST['confirmDeleteBook'])){
                                $newEntry->deleteBookFromDatabase();
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