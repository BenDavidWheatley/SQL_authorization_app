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
        $sql = "SELECT * FROM users WHERE username = '$newMemberUserName'";
        global $mysqli;
        $checkUserName = $mysqli->query($sql);
        $usernameValid = $checkUserName->fetch_assoc();
            if($usernameValid['username'] === $newMemberUserName) {
                echo 'username already exists';
            }else {               
                echo 'New user created' . "<br>";
                $newUser = "INSERT INTO users (username, user_password, user_first_name, user_surname, user_email)
                            VALUES ('$newMemberUserName', '$newMemberPassword', '$newMemberName', '$newMemberSurname', '$newMemberEmail')";
                $mysqli->query($newUser);               
            } 
    } 

    public function login() {
        $userName = $_POST['member'];
        $password = $_POST['memberPassword'];
        $sql = "SELECT * FROM users WHERE username = '$userName'";  
        global $mysqli;                
        $memberInfo = $mysqli->query($sql);
        $memberCheck = $memberInfo->fetch_assoc();    
        $_SESSION['isStaff'] = FALSE;           
            if($memberCheck['username'] === $userName && $memberCheck['user_password'] === $password){
                header("Location: mainPage.php");
                exit();
            } else {
                echo 'The username or password is incorrect';
            } 
    }
    public function staffLogin(){
        $staffNumber = $_POST['staffNumber'];
        $password = $_POST['staffPassword'];
        $sql = "SELECT * FROM users WHERE staff_number = '$staffNumber'";
        global $mysqli;
        $staff = $mysqli->query($sql);
        $validateStaff = $staff->fetch_assoc();
        $_SESSION['isStaff'] = TRUE;
            if($validateStaff['staff_number'] === $staffNumber && $validateStaff['user_password'] === $password){              
                header("Location: editLibrary.php");                              
            } else {
                echo 'The staff number or password is incorrect';
            }
    }
    public function checkIfStaff(){
    }
};

$newUser = new NewMember;
    $newUser->setName($_SESSION['newMemberName']);
    $newUser->setSurname($_SESSION['newMemberSurname']);
    $newUser->setFullName();
    $newUser->setEmail($_POST['newMemberEmail']);
    $newUser->setUserName($_POST['newMemberUserName']);
    $newUser->setPassword($_POST['newMemberPassword']);



