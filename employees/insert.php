<?php 
require_once("../db.php");

$emp_name = $_POST['emp_name'];
$date_of_join = $_POST['date_of_join'];
$designation = $_POST['designation'];
$salary = $_POST['salary'];
$username = $_POST['username'];
$password = $_POST['password'];

echo $emp_name.$date_of_join.$designation.$salary.$username.$password;

mysqli_query($DB['connection'],"INSERT INTO 
    employees(
        emp_name,
        date_of_join,
        designation,
        salary,
        username,
        password
    )
    values(
        '$emp_name',
        '$date_of_join',
        '$designation',
        '$salary',
        '$username',
        '$password'
    )");
checkFail();
header("Location: ./");
?>