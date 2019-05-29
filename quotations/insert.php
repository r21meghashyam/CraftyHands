<?php 
require_once("../db.php");



$supplier_id  = $_POST['supplier_id'];
$item_id_array = $_POST['item_id'];
$item_quantity_array = $_POST['item_quantity'];

$result = mysqli_query($DB['connection'],"INSERT INTO 
quotationsmaster(supplier_id,date)
values ($supplier_id,'".date("y-m-d")."')");
checkFail();
$quotation_id =  mysqli_insert_id($DB['connection']);

for($i=0;$i<count($item_id_array);$i++){
    mysqli_query($DB['connection'],"INSERT INTO 
        quotationsslave
        values ($quotation_id,".$item_id_array[$i].",".$item_quantity_array[$i].") ");
   checkFail();
    $result = mysqli_query($DB['connection'],"select item_quantity from items where item_id=".$item_id_array[$i]);
    $row = mysqli_fetch_array($result);
    $item_quantity = $row['item_quantity']+$item_quantity_array[$i];
    mysqli_query($DB['connection'],"update items set item_quantity=$item_quantity where item_id=".$item_id_array[$i]);
   checkFail();
}
header("Location: ./");
?>