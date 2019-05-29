<?php 
require_once("../db.php");

$item_id = $_POST['item_id'];
$item_name = $_POST['item_name'];
$item_cost_price = $_POST['item_cost_price'];
$item_selling_price = $_POST['item_selling_price'];
$item_mrp = $_POST['item_mrp'];
$item_quanity = $_POST['item_quanity'];
$supplier_id = $_POST['supplier_id'];
mysqli_query($DB['connection'],"UPDATE items SET
item_name='$item_name',
item_cost_price=$item_cost_price,
item_selling_price=$item_selling_price,
item_mrp=$item_mrp,
item_quantity=$item_quanity,
supplier_id=$supplier_id
where item_id=$item_id");
checkFail();
header("Location: ./");
?>