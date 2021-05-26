<?php session_start();
include('connect.php');

if(isset($_POST['newMemberSubmit'])){
    //THE VARIABLES WERE SESSIONS - JUST IN CASE SOMETHING DOESN'T WORK
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

    $sql = "SELECT * FROM users WHERE username = '$newMemberUserName'";
    $checkUserName = $mysqli->query($sql);
    $usernameValid = $checkUserName->fetch_assoc();
    if($usernameValid['username'] === $newMemberUserName) {
        echo 'username already exists';
    }else {
        //header("Location: newAccount.php");
        ECHO 'NEW USER CREATED' . "<br>";
        $newUser = "INSERT INTO users (username, user_password, user_first_name, user_surname, user_email)
                VALUES ('$newMemberUserName', '$newMemberPassword', '$newMemberName', '$newMemberSurname', '$newMemberEmail')";
                echo $newUser;
        $mysqli->query($newUser);
        
    } 
}

class NewMember {
    private $firstName;
    private $surname;
    private $fullName;
    private $email;
    private $userName;
    private $password;

    // ******** SETTERS ********

    public function setName ($firstName){
        $this->firstName = $firstName;
    }
    public function setSurname ($surname){
        $this->surname = $surname;
    }
    public function setFullName (){
        $this->fullname = $this->firstName . " " . $this->surname;
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
};


$newUser = new NewMember;
    $newUser->setName($newMemberName);
    $newUser->setSurname($newMemberSurname);
    $newUser->setFullName();   
    $newUser->setEmail($newMemberEmail);
    $newUser->setUserName($newMemberUserName);
    $newUser->setPassword($newMemberPassword);




