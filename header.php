<?php  $newEntry->fine(); 
if ($_SESSION['loggedIn'] != 1){
    echo "<h2>You must be logged in to view this page</h2>
            <a href='index.php'><p>Back to login</p></a>";

die;
}?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="style/style.css" type="text/css">
        <title>Library App</title>
    </head>

    <body>
        <div id='headerContainer'>
            <section>    
                           
                <?php     
                                 
                    echo "<a href='mainPage.php'><p>Home</p></a>";
                    echo "
                    <form method='post' action='index.php'>
                        <button type='submit' name='logOut'>Log out</button>
                    </form>";               
                if($_SESSION['isStaff'] === TRUE){
                    echo "<a href='editLibrary.php'><p>Edit Library</p></a>";   
                    echo "<a href='searchUser.php'><p>Search User</p></a>";                
                    }   
                if($_SESSION['isStaff'] === FALSE){          
                    echo "<a href='profile.php'><p>Account</p></a>";
                }
                echo "<form method='POST' action='cart.php'>
                <button type='submit' name='viewCart'>View Cart</button>   
                </form>";  
                ?>              
            </section>
        </div>
        <div>
            <?php
                 $curPageName = substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1); 
                
                if($_SESSION['isStaff'] != TRUE && $curPageName != 'confirmCheckOut.php'){
                $newEntry->availableAllowance();
                }
            ?>
        </div>
        <script src='script/script.js'></script>
    </body>

</html>