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
                    <section>
                        <p>Search by username</p>
                        <form method='POST'>
                            <label for='searchUsername'>Username</label>
                            <input type='text' name='searchUsername'>

                            <button type='submit' name='searchUser'>Submit</button>
                        </form> 

                        <p>Search by surname</p>
                        <form method='POST'>

                            <label for='searchSurname'>Surname</label>
                            <input type='text' name='searchSurname'>

                            <button type='submit' name='searchUser'>Submit</button>
                        </form> 
                    </section>
                    <section>
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
                    </section>
                </div>

                <footer>
                    <?php include('footer.php') ?>
                </footer>
                <script src='script/script.js'></script>
            </div>
        </div>

    </body> 
</html>