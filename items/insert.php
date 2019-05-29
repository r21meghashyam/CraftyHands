<?php 
require_once("../db.php");

$item_name = $_POST['item_name'];
$item_cost_price = $_POST['item_cost_price'];
$item_selling_price = $_POST['item_selling_price'];
$item_mrp = $_POST['item_mrp'];
$item_quanity = $_POST['item_quanity'];
$supplier_id = $_POST['supplier_id'];
mysqli_query($DB['connection'],"INSERT INTO 
items(item_name,item_cost_price,item_selling_price,item_mrp,item_quantity,supplier_id) 
values ('$item_name',$item_cost_price,$item_selling_price,$item_mrp,$item_quanity,
$supplier_id )");
checkFail();
header("Location: ./");
?>