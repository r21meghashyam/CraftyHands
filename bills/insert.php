<?php 
require_once("../db.php");


print_r($_POST);
$buyer_type = $_POST['buyer_type'];
$name = $_POST['name'];
$contact = $_POST['contact'];
$item_id_array = $_POST['item_id'];
$item_quantity_array = $_POST['item_quantity'];

$result = mysqli_query($DB['connection'],"INSERT INTO 
billingmaster(customer_name,contact,date,type)
values ('$name','$contact','".date('y-m-d h:i:s')."','$buyer_type')");
if(!empty(mysqli_errno($DB['connection']))){
    include("../failed.php");
    die();
}
$bill_id =  mysqli_insert_id($DB['connection']);
$total=0;
for($i=0;$i<count($item_id_array);$i++){
    mysqli_query($DB['connection'],"INSERT INTO 
        billingslave
        values ($bill_id,".$item_id_array[$i].",".$item_quantity_array[$i].") ");
    if(!empty(mysqli_errno($DB['connection']))){
        include("../failed.php");
        die();
    }

    $result = mysqli_query($DB['connection'],"select item_quantity,item_selling_price,item_mrp from items where item_id=".$item_id_array[$i]);
    $row = mysqli_fetch_array($result);
    echo $total."/";
    $total += ($buyer_type=="Customers"?$row['item_mrp']:$row['item_selling_price'])*$item_quantity_array[$i];
    $item_quantity = $row['item_quantity']-$item_quantity_array[$i];
    mysqli_query($DB['connection'],"update items set item_quantity=$item_quantity where item_id=".$item_id_array[$i]);
    if(!empty(mysqli_errno($DB['connection']))){
        include("../failed.php");
        die();
    }
}
echo $total."/";
$total += $total*$GLOBALS['gst']/100;
echo $total;

mysqli_query($DB['connection'],"update billingMaster set amount=$total where bill_id=".$bill_id);
    if(!empty(mysqli_errno($DB['connection']))){
        include("../failed.php");
        die();
    }
header("Location: ./view.php?id=$bill_id&type=$buyer_type");
?>