<?php 
require_once("../db.php");

$gst = $_POST['gst'];
mysqli_query($DB['connection'],"UPDATE settings SET
gst='$gst' where id=1");
checkFail();
header("Location: ../");
?>