<?php

if (isset($_POST['resetRequestSubmit)'])){
    $selector = bin2hex(random_bytes(8));
    $token = random_bytes(32);
    
    $url = "http://localhost:8888/projects/SQL_authorization_app/createNewPassword.php?selector=" . $selector . "&validator=" . bin2hex($token);
    
    $expires = date("u") + 600;

    require ('connect.php');

    $userEmail = $_POST['resetEmail'];

    $sql = "DELETE FROM pwdReset WHERE pwdResetEmail=?;";
    $stmt = mysqli_stmt_init($mysqli);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            echo "There was an error";
            exit;
        } else {
            mysqli_stmt_bind_param($stmt, "s", $userEmail);
            mysqli_stmt_execute($stmt);
        }
    
    $sql = "INSERT INTO pwdReset (pwdResetEmail, pwdResetSelector, pwdResetToken, pwdResetExpires) VALUES (?, ?, ?, ?,)";

    $stmt = mysqli_stmt_init($mysqli);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            echo "There was an error";
            exit;
        } else {
            $hashedToken = password_hash($token, PASSWORD_DEFAULT);
            mysqli_stmt_bind_param($stmt, "ssss", $userEmail, $selector, $hashedToken, $expires);
            mysqli_stmt_execute($stmt);
        }

    mysqli_stmt_close($stmt);
    mysqli_close(); 

    $to = $userEmail;

    $subject = "Reset your password for the Inner City Library London";

    $message = '<p> We recieved a password reset request. The link to reset your password is below.
    if you did not make this request, you can ignore this email</p>';

    $message .= '<p>Here is your password reset link:  </br>';
    $message .= '<a href="' . $url . '">' . $url . '</a></p>';

    $headers = "From: Inner City Library, London <info@innercitylibrary.com>\r\n";
    $headers .= "reply-to: info@innercitylibrary.com\r\n";
    $headers .= "Content-type: text/html\r\n";

    mail($to, $subject, $message, $headers);

    header("Location: forgotPassword.php?reset=success");

} else {
    header('index.php');
}