<?php
session_start();
include('connect.php');
include('membersClassOOP.php');
include('libraryClassOOP.php');
$newUser->editUser()
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
                    <?php include('header.php') ?>
                </header>
                <div id='profilpic'>
                    <section>
                        <div id='userImageContainer'>
                            <?php $newUser->displayProfilePic(); ?>                           
                        </div>
                       
                        <button onclick='showPicBox()'>Change user Picture</button>                   
                    </section>               
                </div>
            
                <div id='userProfileContainer'>
                    <section id='usersName'>
                        <h2>Name</h2>
                        <p><?php echo $newUser->getFirstName() ?></p>
                        <button onclick='showBox("editFirstName")'>Change first name</button>                       
                    </section>
                    <section id='usersSurname'>
                        <h2>Surname</h2>
                        <p><?php echo $newUser->getSurname() ?></p>
                        <button onclick='showBox("editSurname")'>Change surname</button>
                    </section>
                    <section id='usersUsername'>
                        <h2>Username</h2>
                        <p><?php echo $newUser->getUsername() ?></p>
                        <button onclick='showBox("editUsername")'>Change username</button>
                    </section>
                    <section id='usersEmail'>
                        <h2>Email</h2>
                        <p><?php echo $newUser->getEmail() ?></p>
                        <button onclick='showBox("editEmail")'>Change email address</button>
                    </section>
                    <section id='usersPassword'>
                        <h2>Password</h2>
                        <p><?php echo $newUser->getPassword() ?></p>
                        <button onclick='showBox("editPassword")'>Change password</button>
                    </section>
                </div>

                <div id='userEdit'>
                    <div id='editFirstName'>
                        <form method='post'>
                            <label for='editFirstName'>Enter new first name</label>
                            <input type='text' name='editFirstName'>
                            <button type='submit'>Submit</button>
                        </form>   
                        <button onclick='hideBox("editFirstName")'>Cancel</button>                     
                    </div>
                    <div id='editSurname'>
                        <form method='post'>
                            <label for='editSurname'>Enter new surname</label>
                            <input type='text' name='editSurname'>
                            <button type='submit'>Submit</button>
                        </form>   
                        <button onclick='hideBox("editSurname")'>Cancel</button>                     
                    </div>
                    <div id='editUsername'>
                        <form method='post'>
                            <label for='editUsername'>Enter new username</label>
                            <input type='text' name='editUsername'>
                            <button type='submit'>Submit</button>
                        </form>   
                        <button onclick='hideBox("editUsername")'>Cancel</button>                     
                    </div>
                    <div id='editEmail'>
                        <form method='post'>
                            <label for='editEmail'>Enter new email</label>
                            <input type='text' name='editEmail'>
                            <button type='submit'>Submit</button>
                        </form>   
                        <button onclick='hideBox("editEmail")'>Cancel</button>                     
                    </div>
                    <div id='editPassword'>
                        <form method='post'>
                            <label for='editPassword'>Enter new password</label>
                            <input type='text' name='editPassword'>
                            <button type='submit'>Submit</button>
                        </form>   
                        <button onclick='hideBox("editPassword")'>Cancel</button>                     
                    </div>
                    <div id='editUserimage'>
                        <section>
                            <form method='post' enctype='multipart/form-data'>
                                <label for='editUserPic'></label>
                                <input type='file' name='editUserPic'>
                                <button type='submit'>Submit</button>
                            </form>
                            
                            <button onclick='hidePicBox()'>Cancel</button>                    
                        </section>              
                    </div>
                </div>
                <div>
                    <?php 
                    $newEntry->currentCheckOut();
                    ?>
                </div>
                <div>
                    <?php   
                        if(isset($_POST['editFirstName'])){
                            $newUser->editFirstName();                          
                        }
                        if(isset($_POST['editSurname'])){
                            $newUser->editSurname();                        
                        }
                        if(isset($_POST['editUsername'])){
                            $newUser->editUsername();
                        }
                        if(isset($_POST['editEmail'])){
                            $newUser->editEmail();
                        }
                        if(isset($_POST['editPassword'])){
                            $newUser->editPassword();
                        }
                        if(isset($_FILES['editUserPic'])){
                                $newUser->editProfilePic();   
                        } 
                    ?>
                </div>

                <footer>
                    <?php include('footer.php') ?>
                </footer>
            </div>
        </div>
        <script src='script/script.js'></script>
    </body>

</html>