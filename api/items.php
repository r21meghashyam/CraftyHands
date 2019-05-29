<?php 

require_once("../db.php");

$supplier_id = $_GET['supplier_id'];

$result = mysqli_query($DB['connection'],"select * from items where supplier_id=".$supplier_id);

$array = Array();
 while($row = mysqli_fetch_array($result)){
     
     array_push($array,Array(
         'item_id'=>$row['item_id'],
         'item_name'=>$row['item_name'],
         'item_cost_price'=>$row['item_cost_price'],
         'item_selling_price'=>$row['item_selling_price'],
         'item_mrp'=>$row['item_mrp'],
         'item_quantity'=>$row['item_quantity'],
     ));
 }

$json = json_encode($array);
print_r($json);

?>