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
            <section>
                <?php
                    $selector = $_GET['selector'];
                    $selector = $_GET['validator'];
                    if (empty($selector) || empty($validator)) {
                        echo "We could not validate your request";
                    } else {
                        if (ctype_xdigit($selector) !== FALSE && ctype_xdigit($validator) !== FALSE ) {
                            ?>
                                <form action='reset.php' method='post'>
                                    <input type='hidden' name='selector' value='<?php echo $selector ?>'>
                                    <input type='hidden' name='validator' value='<?php echo $validator ?>'>
                                    <input type='password' name='pwd' placeholder='Enter a new password'>
                                    <input type='password' name='pwdRepeat' placeholder='Repeat a new password'>
                                    <button type='submit' name='resetPasswordSubmit'>Reset Button</button>
                                </form>
                            <?php
                        }
                    }
                ?>
            </section>             
        </div>
        <script src='script/script.js'></script>
    </body> 
</html>