<?php 
session_start();
include('function.php');
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
                        $userName = $_POST['member'];
                        $password = $_POST['memberPassword'];
                        $sqled = "SELECT * FROM users WHERE username = '$userName'";                  
                        $memberInfo = $mysqli->query($sqled);
                        $memberCheck = $memberInfo->fetch_assoc();               
                            if($memberCheck['username'] === $userName && $memberCheck['user_password'] === $password){
                                header("Location: mainPage.php");
                                exit();
                            } else {
                                echo 'The username or password is incorrect';
                            }
                    }?>

                <div id='staffContainer'>
                    <form id='staffLoginForm' method='post' action='staff.php'>
                        <label for='staffMember'>Staff ID</label>
                        <input id='staffMember' name='staffMember' type='text'>

                        <label for='staffMemberPassword'>Password</label>
                        <input id='staffMemberPassword' name='staffMemberPassword' type='text'>

                        <button type='submit'>Login</button>                
                    </form>
                    <button onclick='member("cancelStaff")'>Cancel</button>
                </div>

                <div id='newMemberContainer'>
                    <form id='newMemberForm'  method='post'>  <!--action='newAccount.php'-->
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
            </section>

            <footer>
                <?php include('footer.php') ?>
            </footer>
        </div>
    </div>
    <script src='script/script.js'></script>
  </body>
</html>