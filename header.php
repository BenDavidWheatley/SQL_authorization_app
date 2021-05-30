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
                <p>LOGO</p>
                <?php if($_SESSION['isStaff'] === TRUE){
                        echo 'add edit database';
                    }?>
            </section>
        </div>
    </body>

</html>