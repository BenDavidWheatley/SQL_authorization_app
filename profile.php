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

    <body class='bodyImage'>
        <header>
            <?php include('header.php') ?>
        </header>
        <main>
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

            <?php include('search.php'); ?>

            <div > 
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
            <section id="profileContainer">
                <div id='profileInformation'>
                    <div id='profilpic'>
                        <section>
                            <div id='userImageContainer'>
                                <?php $newUser->displayProfilePic(); ?>                           
                            </div>
                            <a href='#userEdit'><button id='changeImageButton' class='login profileImg' onclick='showBox("editUserImage")'>Change user Picture</button></a>                  
                        </section>               
                    </div>
                    <div id='userProfileContainer'>
                        <section class='userDetails' id='usersName'>
                            <h4>Name - <span><?php echo $newUser->getFirstName()?></span></h4>
                            <a href='#userEdit'><button  class='login' onclick='showBox("editFirstName")'>Change first name</button></a>                       
                        </section>
                        <section class='userDetails' id='usersSurname'>
                            <h4>Surname - <span><?php echo $newUser->getSurname()?></span></h4>
                            <a href='#userEdit'><button class='login'  onclick='showBox("editSurname")'>Change surname</button></a> 
                        </section>
                        <section class='userDetails' id='usersUsername'>
                            <h4>Username - <span><?php echo $newUser->getUsername()?></span></h4>
                            <a href='#userEdit'><button class='login'  onclick='showBox("editUsername")'>Change username</button></a> 
                        </section>
                        <section class='userDetails' id='usersEmail'>
                            <h4>Email - <span><?php echo $newUser->getEmail()?></span></h4>
                            <a href='#userEdit'><button class='login' onclick='showBox("editEmail")'>Change email address</button></a> 
                        </section>
                        <section class='userDetails bottomButton' id='usersPassword'>
                            <h4>Password - </h4>
                            <a href='#userEdit'><button class='login' onclick='showBox("editPassword")'>Change password</button></a> 
                        </section>
                    </div>
                </div>
                <div id='accountBookInformation'>

                    <?php $newEntry->currentCheckOut(); ?>
                </div>
                <div id='userEdit' class='editAccount'>
                        <div id='editFirstName'>
                            <form class='editProfileForm' method='post'>
                                <label for='editFirstName'>Enter new first name</label>
                                <input type='text' name='editFirstName'>
                                <button class='loginButtons' type='submit'>Submit</button>
                            </form>   
                            <button class='loginButtons' onclick='hideBox("editFirstName")'>Cancel</button>                     
                        </div>
                        <div id='editSurname'>
                            <form class='editProfileForm' method='post'>
                                <label for='editSurname'>Enter new surname</label>
                                <input type='text' name='editSurname'>
                                <button class='loginButtons' type='submit'>Submit</button>
                            </form>   
                            <button class='loginButtons'  onclick='hideBox("editSurname")'>Cancel</button>                     
                        </div>
                        <div id='editUsername'>
                            <form class='editProfileForm' method='post'>
                                <label for='editUsername'>Enter new username</label>
                                <input type='text' name='editUsername'>
                                <button class='loginButtons' type='submit'>Submit</button>
                            </form>   
                            <button class='loginButtons' onclick='hideBox("editUsername")'>Cancel</button>                     
                        </div>
                        <div id='editEmail'>
                            <form class='editProfileForm' method='post'>
                                <label for='editEmail'>Enter new email</label>
                                <input type='text' name='editEmail'>
                                <button class='loginButtons' type='submit'>Submit</button>
                            </form>   
                            <button class='loginButtons' onclick='hideBox("editEmail")'>Cancel</button>                     
                        </div>
                        <div id='editPassword'>
                            <form class='editProfileForm' method='post'>
                                <label for='editPassword'>Enter new password</label>
                                <input type='text' name='editPassword'>
                                <button class='loginButtons'  type='submit'>Submit</button>
                            </form>   
                            <button class='loginButtons' onclick='hideBox("editPassword")'>Cancel</button>                     
                        </div>
                        <div id='editUserImage'>
                            <form class='editProfileForm' method='post' enctype='multipart/form-data'>
                                <label for='editUserPic'>Choose your new image</label>
                                <input type='file' name='editUserPic'>
                                <button class='loginButtons' type='submit'>Submit</button>
                            </form>                              
                            <button class='loginButtons' onclick='hideBox("editUserImage")'>Cancel</button>                                                      
                        </div>
                    </div>
                </div>
            </section>
        </main>
        <footer class='footer' id='footerContainer'>
            <?php include('footer.php') ?>
        </footer>
        <script src='script/script.js'></script>
    </body>
    
</html>