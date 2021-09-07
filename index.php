<?php 
session_start();
include('membersClassOOP.php');
include('login.php');
include('connect.php');
$mysqli->query($sql);

if (isset($_POST['logout_x'])){
    $newUser->logout();
}

?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="style/style.css" type="text/css">
    <title>Library App</title>
  </head>

  <body id='loginBody'>
    <section id='loginPage'>
        <section id='loginImageContainer'>
            <img id='loginImage' src='assets/logo.png'>
        </section>
        
        <!-- LOGIN BUTTONS -->
        <section id='loginContainer'>              
            <section  class='transform'  id='loginTitle'>
                <h2>Welcome to the Inner City Library</h2>
                <h5>Sign up or login to view library content</h5>
            </section>
            
            <section class='box transform' id='loginTypeContainer'>
                <div> 
                    <button class='loginButtons' id='memberButton' onclick="setTimeout(member, 500, 'memberContainer');">Member</button>
                </div>
                <div>
                    <button class='loginButtons' onclick="setTimeout(member, 500, 'staffContainer');">Staff</button>
                </div>
                <div>
                    <button class='loginButtons' onclick="setTimeout(member, 500, 'newMemberContainer');">Create Account</botton>
                </div>
                
            </section>

            <!-- LOGIN INPUT -->

            <section>
                <div class="mainLoginContainers" id='memberContainer'>           
                    <form class='form' id='memberLoginForm' method='post' >
                        
                        <label for='member'>Member ID</label>
                        <input id='memberLogin' name='member' type='text'>
                        
                        <label for='memberPassword'>Password</label>
                        <input id='memberPassword' name='memberPassword' type='password'>

                        <button class='loginButtons'  type='submit' name='submitMember'>Login</button>
                    </form>   
                    <div>
                        <a href='forgotPassword.php'><button class='loginButtons' >Forgot username or password</button></a> 
                    </div>                                   
                    <div>           
                        <button class='loginButtons cancel'  onclick='member("cancelMember")'>Cancel</button>   
                    </div>  
                </div>
                
                <div class="mainLoginContainers" id='staffContainer'>
                    <form class='form'  id='staffLoginForm' method='post'>
                        <label for='staffMember'>Staff ID</label>
                        <input id='staffMember' name='staffNumber' type='text'>

                        <label for='staffPassword'>Password</label>
                        <input id='staffPassword' name='staffPassword' type='password'>

                        <button class='loginButtons' type='submit' name='staffLogin'>Login</button>                
                    </form>
                    <button class='loginButtons cancel' onclick='member("cancelStaff")'>Cancel</button>
                </div>
                <?php 

                    // Checks to see if the relevant submit buttons have been clicked 

                    if(isset($_POST['staffLogin'])){                      
                        $newUser->staffLogin();
                    }                 
                    if(isset($_POST['submitMember'])){                     
                        $newUser->login();
                    }                 
                    ?>
                <div  class="mainLoginContainers" id='newMemberContainer'>
                    <form  class='form' id='newMemberForm'  method='post' enctype='multipart/form-data'>
                        <label for='newMemberFirstName'>First Name</label>
                        <input id='newMemberFirstName' name='newMemberFirstName' type='text'>

                        <label for='newMemberSurname'>Surname</label>
                        <input id='newMemberSurname' name='newMemberSurname' type='text'>

                        <label for='newMemberEmail'>Email Address</label>
                        <input id='newMemberEmail' name='newMemberEmail' type='text'>

                        <label for='newMemberUserName'>Create username</label>
                        <input id='newMemberUserName' name='newMemberUserName' type='text'>

                        <label for='NewMemberPassword'>Create Password</label>
                        <input id='newMemberPassword' name='newMemberPassword' type='password'>

                        <label for='repeatMemberPassword'>Repeat Password</label>
                        <input id='newMemberPassword' name='repeatMemberPassword' type='password'>

                        <label for='profilePic'>Upload a profile pic</label>
                        <input id='profilePic' name='profilePic' type='file'>

                        <button class='loginButtons'  type='submit' name='newMemberSubmit' value='newMemberSubmit'>Create Account</button>              
                    </form>
                    <button id='loginCancel' class='loginButtons cancel' onclick='member("cancelNewMember")'>Cancel</button>
                </div> 
                <?php 
                    if(isset($_POST['newMemberSubmit'])){
                        if ($_POST['newMemberPassword'] === $_POST['repeatMemberPassword']) {
                            $newUser->newUserAccount();
                        } else {
                            echo "<h2 id='textError' class='textError'>The passwords do not match</h2>";
                        }
                    }?>
            </section>           
        </section>
    </section>
    
    <script src='script/script.js'></script>
  </body>
</html>