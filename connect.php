<?php

$db_host = 'sql4.freesqldatabase.com';
  $db_user = 'sql4424350';
  $db_password = 'YPkriKzIzf';
  $db_db = 'sql4424350';
  $db_port = 	3306;

  $mysqli = new mysqli(
    $db_host,
    $db_user,
    $db_password,
    $db_db
  );





 /* $db_host = 'localhost';
  $db_user = 'root';
  $db_password = 'root';
  $db_db = 'library_authorisation';
  $db_port = 8889;

  $mysqli = new mysqli(
    $db_host,
    $db_user,
    $db_password,
    $db_db
  ); */

//  if ($mysqli->connect_error) {
//    echo 'Errno: '.$mysqli->connect_errno;
//    echo '<br>';
//    echo 'Error: '.$mysqli->connect_error;
//    exit();
//  }

  //echo 'Success: A proper connection to MySQL was made.';
//  echo '<br>';
//  echo 'Host information: '.$mysqli->host_info;
//  echo '<br>';
//  echo 'Protocol version: '.$mysqli->protocol_version;

 // $mysqli->close();
?>