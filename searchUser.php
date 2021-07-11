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
                <div >
                    <section id='searchLibrary'>
                        <div class='searchDatabaseContainer'>
                            <form class='searchDatabase' method='post'>
                                <input  name='searchUsername' type='text' placeholder='search user by username'>
                                <button  type='submit' name='searchUser' ><img src='assets/header-logos/searchIcon.png'></button>
                            </form>
                                <div class='spacer'>
                                </div>
                            <form class='searchDatabase' method='post'>   
                                <input id='searchAuthor' name='searchSurname' type='text' placeholder='search user by surname'>
                                <button type='submit' name='searchUser' value='search'><img src='assets/header-logos/searchIcon.png'></button>     
                            </form>                                                                 
                        </div>
                    </section>
                        <?php 
                            if (isset($_POST['searchUser'])){                          
                                $newUser->searchUser();
                            } 
                            if (isset($_POST['selectThisUser'])){
                                $newUser->selectThisUser();
                            }
                            if (isset($_POST['payFine'])){
                                $newEntry->payFine();
                            }
                        ?>
                    <section id='searchUser' class='container'>
                        <h2>User Search</h2>
                        <p>Use the search bars above to search for a user within the Library.</p>
                        <p>Once you have selected your user you will be able to view the books they have checked out, books that are late and any fines</p>
                        <p>Should the user pay their fine, you will be able to clear it form this page.</p>
                    </section>
                </div>
                <footer class='footer' id='footerContainer'>
                    <?php include('footer.php') ?>
                </footer>
                <script src='script/script.js'></script>
            </div>
        </div>

    </body> 
</html>