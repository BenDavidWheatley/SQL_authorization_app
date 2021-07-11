<?php 
session_start();
include('login.php');
include('connect.php');
include('editLibrary');

if(isset($_POST['newMemberSubmit'])){
    $_SESSION['newMemberName'] = $_POST['newMemberFirstName'];
    $_SESSION['newMemberSurname'] = $_POST['newMemberSurname'];
    $_SESSION['newMemberEmail'] = $_POST['newMemberEmail'];
    $_SESSION['newMemberUserName'] = $_POST['newMemberUserName'];
    $_SESSION['newMemberPassword'] = $_POST['newMemberPassword'];

    $newMemberName = $_SESSION['newMemberName'];
    $newMemberSurname = $_SESSION['newMemberSurname'];
    $newMemberEmail = $_SESSION['newMemberEmail'];
    $newMemberUserName = $_SESSION['newMemberUserName'];
    $newMemberPassword = $_SESSION['newMemberPassword'];
}
class NewMember {
    private $firstName;
    private $surname;
    private $fullName;
    private $email;
    private $userName;
    private $password;
    private $staff;
    private $default = 'defaultProfile.png';

    // ******** SETTERS ********

    public function setName ($firstName){
        $this->firstName = $firstName;
    }
    public function setSurname ($surname){
        $this->surname = $surname;
    }
    public function setFullName (){
        $this->fullName = $this->firstName . " " . $this->surname;
    }
    public function setEmail ($email) {
        $this->email = ($email);
    }
    public function setUserName ($userName){
        $this->userName = ($userName);
    }
    public function setPassword ($password){
        $this->password = ($password);
    }

    // ******** GETTERS ********

    public function getFirstName(){
        echo $this->firstName;
    }
    public function getSurname(){
        echo $this->surname;
    }
    public function getFullName(){
        echo $this->fullName;
    }
    public function getEmail(){
        echo $this->email;
    }
    public function getUserName(){
        echo $this->userName;
    }
    public function getPassword(){
        echo $this->password;
    }
    public function getStaff(){
        echo $this->staff;
    }

    // ******** METHODS ********

    public function newUserAccount () {
        $newMemberName = $this->firstName;
        $newMemberSurname = $this->surname;
        $newMemberEmail = $this->email;
        $newMemberUserName = $this->userName;
        $newMemberPassword = $this->password;
        $defaultImage = $this->default; 
        $sql = "SELECT * FROM users WHERE username = '$newMemberUserName'";
            global $mysqli;
        $checkUserName = $mysqli->query($sql);
        $usernameValid = $checkUserName->fetch_assoc();
            if($usernameValid['username'] != $newMemberUserName) {
                if ($_FILES['profilePic']['error'] != 0){
                    $newUserNoImage = "INSERT INTO users (username, user_password, user_first_name, user_surname, user_email, user_image, fineTotal)
                                        VALUES ('$newMemberUserName', '$newMemberPassword', '$newMemberName', '$newMemberSurname', '$newMemberEmail', '$defaultImage', 0)";
                    global $mysqli;
                        if ($mysqli->query($newUserNoImage)) {
                            echo "<script>window.location.href='newAccount.php';</script>";
                            exit;
                        } else {
                            echo "There was an error creating the account: Username or email already exists";                         
                        };    
                }else if ($_FILES['profilePic']['error'] === 0){
                        $fileName = $_FILES['profilePic']['name'];
                        $fileTmpName = $_FILES['profilePic']['tmp_name'];
                        $fileSize = $_FILES['profilePic']['size'];
                        $fileError = $_FILES['profilePic']['error'];
                        $fileType = $_FILES['profilePic']['type'];
                        $fileExt = explode('.', $fileName);
                        $fileActualExt = strtolower(end($fileExt));
                        $allowed = array('jpg', 'jpeg', 'png');
                        if (in_array($fileActualExt, $allowed)) {
                            if ($fileError === 0){
                                if ($fileSize < 5000000){
                                    $fileNameNew = uniqid('', true) . "." . $fileActualExt;
                                    $fileDestination = 'assets/users/' . $fileNameNew;
                                    move_uploaded_file($fileTmpName, $fileDestination);
                                    $newUser = "INSERT INTO users (username, user_password, user_first_name, user_surname, user_email, user_image)
                                                VALUES ('$newMemberUserName', '$newMemberPassword', '$newMemberName', '$newMemberSurname', '$newMemberEmail', '$fileNameNew')";
                                        global $mysqli;
                                        if ($mysqli->query($newUser) === TRUE) {
                                            echo "<script>window.location.href='newAccount.php';</script>";
                                            } else {
                                                echo "Error <br>" .  $mysqli->error;
                                            }                
                                } else {
                                    echo "Your file is too big, image must be less then 5mb";
                                }
                            } else {
                                echo 'There was an error uploading your file';
                            }
                        } else {
                            echo 'You cannot upload files of this type, file must be either jpeg, jpg or png';
                        };  
                }
            }else {               
                echo 'username already exists';       
            } 
    } 
    public function login() {
        $_SESSION['loggedIn'] = true;
        $userName = $_POST['member'];
        $password = $_POST['memberPassword'];     
        $sql = "SELECT * FROM users WHERE username = '$userName'";  
        global $mysqli;                
        $memberInfo = $mysqli->query($sql);
        $memberCheck = $memberInfo->fetch_assoc();     
        $_SESSION['isStaff'] = FALSE;           
            if($memberCheck['username'] === $userName && $memberCheck['user_password'] === $password){
                $_SESSION['userId'] = $memberCheck['id'];
                header("Location: mainPage.php"); 
            } else {
                echo "<h3 id='textError' class='textError'>The username or password is incorrect</h3>";
            } 
    }
    public function staffLogin(){
        $_SESSION['loggedIn'] = true;
        $staffNumber = $_POST['staffNumber'];
        $password = $_POST['staffPassword'];
        $sql = "SELECT * FROM users WHERE staff_number = '$staffNumber'";
        global $mysqli;
        $staff = $mysqli->query($sql);
        $validateStaff = $staff->fetch_assoc();
        $_SESSION['isStaff'] = TRUE ;
            if($validateStaff['staff_number'] === $staffNumber && $validateStaff['user_password'] === $password){              
                header("Location: mainPage.php");                              
            } else {
                echo "<h3 id='textError' class='textError'>The staff number or password is incorrect</h3>";
            }
        return $_SESSION['isStaff'];
    }
    public function logout () {
        header("Location: index.php");
        $_SESSION['loggedIn'] = false;
    }
    public function editUser(){
        $id = $_SESSION['userId'];
        $sql = "SELECT * FROM users WHERE id = '$id'";      
            global $mysqli;
        $queryUser = $mysqli->query($sql);
        $getUser = $queryUser->fetch_assoc();
        $this->firstName = $getUser['user_first_name'];
        $this->surname = $getUser['user_surname'];
        $this->email = $getUser['user_email'];
        $this->userName = $getUser['username'];
        $this->password = $getUser['user_password'];
        $this->staff = $getUser['staffNumber'];
    }
    public function displayProfilePic() {       
        $id = $_SESSION['userId'];       
        $sql = "SELECT * FROM users WHERE id = '$id'";      
            global $mysqli;
        $user = $mysqli->query($sql);       
        $userImage = $user->fetch_assoc();
            if(!$userImage['user_image']){
                echo "<img class='image' src='assets/users/" . $userImage['user_image'] . "'>";
            } else {
                echo "<img class='image' src='assets/users/" . $userImage['user_image'] . "'>";
            }
    }

/******** Edit Profile functions ********/ 

    public function editProfilePic() {
        if ($_FILES['editUserPic']['error'] === 0) { 
            $id = $_SESSION['userId'];   
            echo $id; 
            $sqlImage = "SELECT user_image FROM users WHERE id = '$id'";          
                global $mysqli;
            $mysqli->query($sqlImage); 
            $fetch = $mysqli->query($sqlImage);    
            $getImage = $fetch->fetch_assoc();
            $oldImage = $getImage['user_image'];       
            $path = "assets/users/" . $oldImage;
                if (file_exists($path)){                 
                    if ($oldImage != 'defaultProfile.png'){
                        unlink($path);
                        $sqlImage = "UPDATE users SET user_image = NULL WHERE id = '$id'";
                        global $mysqli;
                        $mysqli->query($sqlImage);
                    } else {
                        $sqlImage = "UPDATE users SET user_image = NULL WHERE id = '$id'";
                        global $mysqli;
                        $mysqli->query($sqlImage);
                    }
                }                
                $fileName = $_FILES['editUserPic']['name'];
                $fileTmpName = $_FILES['editUserPic']['tmp_name'];
                $fileSize = $_FILES['editUserPic']['size'];
                $fileError = $_FILES['editUserPic']['error'];
                $fileType = $_FILES['editUserPic']['type'];
                $fileExt = explode('.', $fileName);
                $fileActualExt = strtolower(end($fileExt));       
                $allowed = array('jpg', 'jpeg', 'png');
                if (in_array($fileActualExt, $allowed)) {
                    if ($fileError === 0){
                        if ($fileSize < 5000000){
                                $fileNameNew = uniqid('', true) . "." . $fileActualExt;
                                $fileDestination = 'assets/users/' . $fileNameNew;
                                    move_uploaded_file($fileTmpName, $fileDestination);  
                                $sql= "UPDATE users SET user_image = '$fileNameNew' WHERE id = '$id'";
                                global $mysqli;
                                    if ($mysqli->query($sql) === TRUE) {  
                                        echo $fileNameNew;                                    
                                        echo "<script>window.location.href='profile.php';</script>";
                                        exit;                                                              
                                        } else {
                                            echo "Error: " .  $mysqli->error;
                                        }                
                            } else {
                                echo "Your file is too big, image should be less the 5mb";
                            }
                        } else {
                            echo 'There was an error uploading your file';
                        }
                    } else {
                        echo 'You cannot upload files of this type, file must be either jpeg, jpg or png';
                    }
                }
                else { 
                    echo "image not edited";
                };                        
    }     
    public function editFirstName(){
        $id = $_SESSION['userId'];
        $newName = $_POST['editFirstName'];
        $sql = "UPDATE users SET user_first_name = '$newName' WHERE id = '$id'";
        global $mysqli;
        if ($mysqli->query($sql)){
            echo "<script>window.location.href='profile.php';</script>";
            exit; 
        }                      
    }
    public function editSurname(){
        $id = $_SESSION['userId'];
        $newSurname = $_POST['editSurname'];
        $sql = "UPDATE users SET user_surname = '$newSurname' WHERE id = '$id'";
        global $mysqli;
        if ($mysqli->query($sql)){
            echo "<script>window.location.href='profile.php';</script>";
            exit; 
        }  
    }
    public function editUserName(){
        $id = $_SESSION['userId'];
        $newUsername = $_POST['editUsername'];       
        $sql = "SELECT * FROM users WHERE username = '$newUsername'";
            global $mysqli;
        $checkUserName = $mysqli->query($sql);
        $usernameValid = $checkUserName->fetch_assoc();
            if($usernameValid['username'] != $newUsername) {
                $sql = "UPDATE users SET username = '$newUsername' WHERE id = '$id'";
                $mysqli->query($sql);
                echo "<script>window.location.href='profile.php';</script>";
                exit; 
            } else {
                echo "<div class='container offsetBook'>
                            <h2>Username already exists</h2>
                            <form method='post'>
                                <button class='loginButtons'>Back</button>
                            </form>
                        </div>";
            }
    }
    public function editEmail(){
        $id = $_SESSION['userId'];
        $newEmail = $_POST['editEmail'];
        $sql = "UPDATE users SET user_email = '$newEmail' WHERE id = '$id'";
        global $mysqli;
        if ($mysqli->query($sql)){
            echo "<script>window.location.href='profile.php';</script>";
            exit;           
        }            
    }
    public function editPassword(){
        $id = $_SESSION['userId'];
        $newPassword = $_POST['editPassword'];
        $sql = "UPDATE users SET user_password = '$newPassword' WHERE id = '$id'";
        global $mysqli;
        if ($mysqli->query($sql)){
            echo "<script>window.location.href='profile.php';</script>";
            exit;           
        } 
    }
    public function searchUser(){        
        if (isset($_POST['searchUsername'])){
            $search = '%' . strtolower($_POST['searchUsername']) . '%';            
            $sqlUsername = "SELECT * FROM users WHERE username LIKE '$search' ORDER BY user_surname ASC";
                global $mysqli;
                $user = $mysqli->query($sqlUsername);
                echo "<section class='libraryUsers container innerContainers overlay'>
                        <table class='searchUserContainer'>
                            <tr class='tableHeaders'>    
                                <th class='userTitles' ><h4>Name</h4></th>
                                <th class='userTitles' ><h4>Username</h4></th>
                                <th class='userTitles' ><h4>Email</h4></th>
                                <th class='userTitles' ><h4>Select User</h4></th>                          
                            </tr>";
                while($userDetails = $user->fetch_assoc()){                   
                        echo "<tr class='searchUserTable'>
                                    <td>" . $userDetails['user_first_name']  . " " .  $userDetails['user_surname'] . "</td>
                                    <td>" . $userDetails['username'] . "</td>                                  
                                    <td>" . $userDetails['user_email'] . "</td>   
                                    <td class='searchUserFormButtons'>    <form method='post'>
                                                <button id='selectUserUsername' class='searchbutton addBook' type='submit' name='selectThisUser' value=" . $userDetails['id'] . ">Select User</button>
                                            </form>
                                    </td>
                                    
                                </tr>
                                <tr>
                                    <td><hr></td>
                                </tr> ";                                                                           
            }
            echo "</table> 
            </section>"; 
        }
        if (isset($_POST['searchSurname'])) {
            $search = '%' . strtolower($_POST['searchSurname']) . '%';
                $sqlSurname = "SELECT * FROM users WHERE user_surname LIKE '$search'";
                global $mysqli;
                $user = $mysqli->query($sqlSurname);
                echo "<section class='libraryUsers container innerContainers overlay'>
                <table class='searchUserContainer'>
                    <tr class='tableHeaders'>    
                        <th class='userTitles' ><h4>Name</h4></th>
                        <th class='userTitles' ><h4>Username</h4></th>
                        <th class='userTitles' ><h4>Email</h4></th>
                        <th class='userTitles' ><h4>Select User</h4></th>                         
                    </tr>";
            while($userDetails = $user->fetch_assoc()){
                echo "<tr class='searchUserTable'>
                            <td>" . $userDetails['user_first_name']  . " " .  $userDetails['user_surname'] . "</td>
                            <td>" . $userDetails['username'] . "</td>                                  
                            <td>" . $userDetails['user_email'] . "</td>   
                            <td>    <form method='post'>
                                        <button id='selectUser' class='searchbutton addBook' type='submit' name='selectThisUser' value=" . $userDetails['id'] . ">Select User</button>
                                    </form>
                            </td>
                        </tr>
                        <tr>
                            <td><hr></td>
                        </tr>";                      
            }
            echo "</table> 
            </section>"; 
        }
    }
    public function selectThisUser() {
        $id = $_POST['selectThisUser'];
        global $mysqli; 
        $sqlTwo = "SELECT * FROM users WHERE id = '$id'";
        $userFineInfo = $mysqli->query($sqlTwo);
        $userFine = $userFineInfo->fetch_assoc();    
            echo"<section class='selectUserContainer containers innerContainers overlay'>
                    <div class='selecteUserDetails '>
                        <h3> User - " . $userFine['user_first_name'] . " " . $userFine['user_surname'] . "</h3>
                        <h3>Fines to pay -  " . $userFine['fineTotal'] . " pounds</h3>";       
            if ($userFine['fineTotal'] > 0){
                echo 
                        "<form method='post'>
                            <button id='payUserFine' class='searchbutton addBook' type='submit' name='payFine' value='" . $userFine['id'] . "'>Pay fine</button>                  
                        </form>";
            }
                echo "</div>";
                   
       
        $sql = "SELECT * FROM users LEFT OUTER JOIN checkedOut ON users.id = checkedOut.users_id WHERE users.id = '$id'";
        $sqlTwo = "SELECT * FROM users LEFT OUTER JOIN checkedOut ON users.id = checkedOut.users_id WHERE users.id = '$id'";
        $user = $mysqli->query($sql);
        $userTwo = $mysqli->query($sqlTwo);
        $usersTwo = $userTwo->fetch_assoc();
        if (!$usersTwo['book_id']){
            echo "<div class='selectUserContainer container innerContainer overlay'><h2>You currently have nothing checked out</h2></div>";
        } else {
        echo "<table class='selectUserTable selectedUserHeading'>
                <tr class='userTitlesContainer'>
                    <th class='coloumnOne' ><h4>Book</h4></th>
                    <th class='coloumnTwo'><h4>Checked out on:</h4></th>
                    <th class='coloumnThree'><h4>Due back on:</h4></th>
                </tr>";
        while($rows = $user->fetch_assoc()){
            $bookId = $rows["book_id"];
            $book = "SELECT * FROM books WHERE book_id = '$bookId'";
            $queryBook = $mysqli->query($book);
            $fetchBook = $queryBook->fetch_assoc();        
            echo    "<tr class='userTitlesContainer'>
                        <td class='coloumnOne'>" . $fetchBook['book_title'] . "</td>
                        <td class='coloumnTwo'>" . $rows['check_out_date'] . "</td>
                        <td class='coloumnThree'>" . $rows['due_date'] . "</td>
                    </tr>";
        }                                                 
        echo "</table>
            </section>";
                        }                      
    }
}; 
$newUser = new NewMember;

    $newUser->setName($_SESSION['newMemberName']);
    $newUser->setSurname($_SESSION['newMemberSurname']);
    $newUser->setFullName();
    $newUser->setEmail($_SESSION['newMemberEmail']);
    $newUser->setUserName($_SESSION['newMemberUserName']);
    $newUser->setPassword($_SESSION['newMemberPassword']);


