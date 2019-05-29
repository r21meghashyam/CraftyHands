<?php 
require_once("../db.php");

$emp_id = $_POST['emp_id'];
$emp_name = $_POST['emp_name'];
$date_of_join = $_POST['date_of_join'];
$designation = $_POST['designation'];
$salary = $_POST['salary'];
$username = $_POST['username'];

mysqli_query($DB['connection'],"UPDATE employees SET
emp_name='$emp_name',
date_of_join='$date_of_join',
designation='$designation',
salary='$salary',
username='$username'
where emp_id=$emp_id");
checkFail();
header("Location: ./");
?>