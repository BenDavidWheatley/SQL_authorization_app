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

                    <section>
                        <?php 

                            if (isset($_POST['searchAuthorSubmit'])){
                                $newEntry->searchAuthor();
                            }
                            if(isset($_POST['searchBook'])){ 
                                $_SESSION['search'] = '%'. $_POST['searchDatabase'] .'%'; 
                                $newEntry->searchBook();
                            }
                            if (isset($_POST['addToCart'])){
                                $newEntry->addToCart();                                                                                                                
                            }
                            if (isset($_POST['checkIn'])){
                                $newEntry->bookCheckin();
                            }
                            if (isset($_POST['edit'])){
                                $newEntry->editBook();
                            }
                            if(isset($_POST['editSubmit'])){
                                $newEntry->submitEdit();
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
                    <section id='eventsAndInfoContainer'>
                    <h1>This is the Events section</h1>
                    
                    </section>
                    
                <footer>
                    <?php include('footer.php') ?>
                </footer>
            </div>
        </div>

        <script src='script/script.js'></script> 
    </body> 
</html>