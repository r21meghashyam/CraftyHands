<?php 
require_once("../db.php");

$supplier_id = $_POST['supplier_id'];
$supplier_name = $_POST['supplier_name'];

mysqli_query($DB['connection'],"update suppliers set supplier_name='$supplier_name' where supplier_id=$supplier_id");
checkFail();
header("Location: ./");
?>