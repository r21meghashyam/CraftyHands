<?php 

require_once("../db.php");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        body{
            margin:0px;
        }
        header{
            background:#900;
            color:#fff;
            padding:20px;
            font-size:20px;
            box-shadow:0px 10px 25px #999; 
        }
        section{
            display:flex;
            align-items: center;
            height: 100vh;
            flex-direction:column;
            justify-content: center;
        }

        .box{
            padding: 20px;
            background: #900;
            color:#fff;
        }
        .box .header{
            text-align:center;
            font-size:20px;
        }
        .input{
            margin-top:10px;
        }
        .box>*{
            padding:10px;
        }
        .box input,.box select{
            width:100%;
            font-size:15px;
            padding:5px;
            color:#999;
            outline:none;

        }
        .button{
            text-align:center;
            padding:20px;
        }
        .button button{
            padding:10px;
            font-size:20px;
            background:#fff;
            color:#900;
            border:none;
        }
        table,th,td{
            border:1px solid #fff;
            border-collapse:collapse;
            padding:5px;
        }
        a{
            color:#fff;
            text-decoration:none;
        }
    </style>
</head>
<?php 
 $result = mysqli_query($DB['connection'],"select * from billingmaster where bill_id=".$_GET['id']);
 $bill = mysqli_fetch_array($result);
?>
<body>
    <header>
        <a href="/" style="text-decoration:none;color:#fff">CraftyHands</a>
    </header>
    <section>
        
        <div class="box">
            <h1 style="text-align:center">Crafty Hands</h1>
            <div style="text-align:right">
                <div>
                    Phone Number: 0824-24500001
                </div>
                <div>
                    Date: <?php echo date("y/m/d h:i:s");?>
                </div>
            </div>
            <div>
                <b>Client Name</b>: <?php echo $bill['customer_name'];?>
            </div>
            <div>
                <b>Client Number</b>: <?php echo $bill['contact'];?>
            </div>
           <table>
            <tr>
                <th>Item No</th>
                <th>Item Name</th>
                <th>Item Price</th>
                <th>Quantity</th>
                <th>Total Price</th>
            </tr>
            <?php 
                
                $result = mysqli_query($DB['connection'],
                "
                select 
                    bs.item_id,
                    item_name,
                    item_selling_price,
                    item_mrp,
                    bs.quantity,
                    item_selling_price*bs.quantity as vendorprice,
                    item_mrp*bs.quantity as customerprice
                from 
                    billingSlave bs,
                    items i 
                where 
                bs.item_id=i.item_id and bill_id=".$_GET['id']);
                checkFail();
                while($row = mysqli_fetch_array($result)){
                   
                    echo '<tr>
                        <th>'.$row['item_id'].'</th>
                        <th>'.$row['item_name'].'</th>
                        <th>'.($_GET['type']=="Customers"?$row['item_mrp']:$row['item_selling_price']).'</th>
                        <th>'.$row['quantity'].'</th>
                        <th>'.($_GET['type']=="Customers"?$row['customerprice']:$row['vendorprice']).'</th>
                       
                    </tr>';
                }
            ?>
           </table>
           <?php 
           $gstvalue = $GLOBALS['gst'];
           
           $total = $bill['amount'];
           $subtotal = $total*100/($gstvalue+100);
           $gstvalue = $total-$subtotal;
           echo '<div>Sub Total: '.$subtotal.'</div>';
           echo '<div>GST @ '.$GLOBALS['gst'].'%: '.$gstvalue.'</div>';
           echo '<div>Total: '.$total.'</div>';
           ?>
           <div>
                <button onclick="print()">Print</button>
           </div>
        </div>
        
    </section>
</body>
</html>