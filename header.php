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
                    echo "<a href='index.php'><p>Logout</p></a>";
                
                if($_SESSION['isStaff'] === TRUE){
                    echo "<a href='editLibrary.php'><p>Edit Library</p></a>";                       
                    }
                if($_SESSION['isStaff'] === FALSE){
                    echo "<a href='profile.php'><p>Edit Profile</p></a>";
                }?>
            </section>
        </div>
    </body>

</html>