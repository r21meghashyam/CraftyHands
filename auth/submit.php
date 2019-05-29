<?php 
require_once("../db.php");

$username = $_POST['username'];
$password = $_POST['password'];

$result = mysqli_query($DB['connection'],"select * from employees where username='$username' and password='$password'");
echo mysqli_error($DB['connection']);
if(!mysqli_fetch_array($result)){
    
    include("failed.php");
    die();
}
session_start();
$_SESSION['username']=$username;
$_SESSION['password']=$password;
header("Location: ../");
?>