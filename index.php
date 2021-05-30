<?php 
session_start();
include('membersClassOOP.php');
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
    <header>
        <?php include('header.php')?>
    <header>

    <!-- LOGIN BUTTONS -->
    <div class='pageContainer'>
        <div class='mainContainer'>
            <section id='loginTypeContainer'>
                <div> 
                    <button onclick='member("memberContainer")'>Member</button>
                </div>
                <div>
                    <button onclick='member("staffContainer")'>Staff</button>
                </div>
                <div>
                    <button onclick='member("newMemberContainer")'>Create Account</botton>
                </div>
            </section>

            <!-- LOGIN INPUT -->

            <section id='login'>
                <div id='memberContainer'>           
                    <form id='memberLoginForm' method='post' >
                        <label for='member'>Member ID</label>
                        <input id='memberLogin' name='member' type='text'>
                        
                        <label for='memberPassword'>Password</label>
                        <input id='memberPassword' name='memberPassword' type='text'>

                        <button type='submit' name='submitMember'>Login</button>
                    </form>   
                    <button onclick='member("cancelMember")'>Cancel</button>   
                </div>
                <?php
                    if(isset($_POST['submitMember'])){
                        $newUser->login();
                    }
                    ?>

                <div id='staffContainer'>
                    <form id='staffLoginForm' method='post'>
                        <label for='staffMember'>Staff ID</label>
                        <input id='staffMember' name='staffNumber' type='text'>

                        <label for='staffPassword'>Password</label>
                        <input id='staffPassword' name='staffPassword' type='text'>

                        <button type='submit' name='staffLogin'>Login</button>                
                    </form>
                    <button onclick='member("cancelStaff")'>Cancel</button>
                </div>
                <?php 
                    if(isset($_POST['staffLogin'])){
                        $newUser->staffLogin();
                    }
                    ?>
                <div id='newMemberContainer'>
                    <form id='newMemberForm'  method='post' >
                        <label for='newMemberFirstName'>First Name</label>
                        <input id='newMemberFirstName' name='newMemberFirstName' type='text'>

                        <label for='newMemberSurname'>Surname</label>
                        <input id='newMemberSurname' name='newMemberSurname' type='text'>

                        <label for='newMemberEmail'>Email Address</label>
                        <input id='newMemberEmail' name='newMemberEmail' type='text'>

                        <label for='newMemberUserName'>Create username</label>
                        <input id='newMemberUserName' name='newMemberUserName' type='text'>

                        <label for='NewMemberPassword'>Create Password</label>
                        <input id='newMemberPassword' name='newMemberPassword' type='text'>

                        <button type='submit' name='newMemberSubmit' value='newMemberSubmit'>Create Account</button>              
                    </form>
                    <button onclick='member("cancelNewMember")'>Cancel</button>
                </div> 
                <?php 
                    if(isset($_POST['newMemberSubmit'])){
                        $newUser->newUserAccount();
                        header("Location: newAccount.php");
                    }?>
            </section>

            <footer>
                <?php include('footer.php') ?>
            </footer>
        </div>
    </div>
    <script src='script/script.js'></script>
  </body>
</html>