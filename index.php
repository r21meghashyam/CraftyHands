<?php 
session_start();
if(!$_SESSION['username']){
    header("Location: ./auth/login.php");
    die();
}
include("home.php");

?>