<?php 
require_once("../db.php");

$name = $_POST['name'];

mysqli_query($DB['connection'],"INSERT INTO suppliers(supplier_name) values('$name')");
checkFail();
header("Location: ./");
?>