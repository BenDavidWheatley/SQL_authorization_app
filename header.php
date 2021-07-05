<?php  $newEntry->fine(); 
include ('memberClassOOP.php');
if ($_SESSION['loggedIn'] != 1){
    echo "<div id='niceTry'>   
            <h2>You must be logged in to view this page</h2>
            <a href='index.php'><button class='login cancel'>Back to login</button></a>
        </div>";
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

    <body id='headerBody'>
        <div id='headerContainer'>
            <section id='headerTitles'>                             
                <?php                                                        
                    echo "<form method='post' action='index.php'>
                            <input class='headerImage' name='logout' type='image' src='assets/header-logos/exit.png'>
                          </form>";      
                    echo "<a href='mainPage.php'><input class='headerImage' type='image' src='assets/header-logos/home.png'></a>";         
                if($_SESSION['isStaff'] === TRUE){
                    echo "<a href='editLibrary.php'><input class='headerImage' type='image' src='assets/header-logos/editLibrary.png'></a>";
                    echo "<a href='searchUser.php'><input class='headerImage' type='image' src='assets/header-logos/searchUser.png'></a>";                              
                    }   
                if($_SESSION['isStaff'] === FALSE){          
                    echo "<a href='profile.php'><input class='headerImage' type='image' src='assets/header-logos/account.png'></a>";
                    echo "<form method='POST' action='cart.php'>
                        <input class='headerImage' type='image' src='assets/header-logos/cart.png'> 
                     </form>";  
                }           
                ?>              
            </section>
            <?php if($_SESSION['isStaff'] === FALSE){
                echo "<section class='allowance'>";
                $curPageName = substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);                    
                if($_SESSION['isStaff'] != TRUE && $curPageName != 'confirmCheckOut.php'){
                $newEntry->availableAllowance();
                echo "</section>";
                } 
                } else {
                    echo "<section>
                         
                        </section>";              
                } ?>
        </div>
        <script src='script/script.js'></script>
    </body>

</html>