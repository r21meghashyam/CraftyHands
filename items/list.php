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
<body>
    <header>
        <a href="/" style="text-decoration:none;color:#fff">CraftyHands</a>
    </header>
    <section>
        
        <div class="box">
            <div class="input">
                <select onchange="window.location=`?supplier=${this.value}`">
                    <option value="">All</option>
                    <?php 
                            $result = mysqli_query($DB['connection'],"select * from suppliers");
                            while($row=mysqli_fetch_array($result)){
                                $selected = "";
                                if(isset($_GET['supplier'])&&$_GET['supplier']==$row['supplier_id'])
                                    $selected="selected";
                                echo '<option value="'.$row['supplier_id'].'" '.$selected.' >'.$row['supplier_name'].'</option>';
                            }
                        ?>
                </select>
            </div>
           <table>
            <tr>
                <th>Item ID.</th>
                <th>Item Name</th>
                <th>Cost Price</th>
                <th>Selling Price</th>
                <th>MRP</th>
                <th>Quantity</th>
                <th>Supplier</th>
                <th>Actions</th>
            </tr>
            <?php 
                $supplier = "";
                if(!empty($_GET['supplier']))
                            $supplier = "AND i.supplier_id=".$_GET['supplier'];
                $result = mysqli_query($DB['connection'],"select * from items i,suppliers s where i.supplier_id=s.supplier_id ".$supplier);
                
                while($row = mysqli_fetch_array($result)){
                   
                    echo '<tr>
                        <th>'.$row['item_id'].'</th>
                        <th>'.$row['item_name'].'</th>
                        <th>'.$row['item_cost_price'].'</th>
                        <th>'.$row['item_selling_price'].'</th>
                        <th>'.$row['item_mrp'].'</th>
                        <th>'.$row['item_quantity'].'</th>
                        <th>'.$row['supplier_name'].'</th>
                        <th>
                            <a href="edit.php?id='.$row['item_id'].'">Edit</a>
                            <a href="delete.php?id='.$row['item_id'].'">Delete</a>
                        </th>
                    </tr>';
                }
            ?>
           </table>
        </div>
    </section>
</body>
</html>