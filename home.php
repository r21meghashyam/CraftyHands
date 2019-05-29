<?php 

require_once("db.php");

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
            justify-content: center;
            flex-direction:column;
        }

        .options a{
            display:block;
            padding:20px;
            margin:10px;
            text-decoration:none;
            background:#900;
            color:#fff;
        }
        .options a:hover{
            background:orange;
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
        <h1>Welcome to crafty Hands</h1>
        <div class="options">
            <a href="suppliers">Suppliers</a>
            <a href="items">Items</a>
            <a href="quotations">Quotations</a>
            <a href="bills">Bills</a>
            <a href="employees">Employees</a>
            <a href="settings">Settings</a>
            <a href="/auth/logout.php">Logout</a>
        </div>
       
           <?php 
           $tr='';
           $result = mysqli_query($DB['connection'],"select * from items i,suppliers s where i.supplier_id=s.supplier_id and item_quantity<50");
                
           while($row = mysqli_fetch_array($result)){
              
               $tr.= '<tr>
                   <th>'.$row['item_id'].'</th>
                   <th>'.$row['item_name'].'</th>
                   <th>'.$row['item_cost_price'].'</th>
                   <th>'.$row['item_selling_price'].'</th>
                   <th>'.$row['item_mrp'].'</th>
                   <th>'.$row['item_quantity'].'</th>
                   <th>'.$row['supplier_name'].'</th>
                  
               </tr>';
           }
           
           if(strlen($tr)>0){
           ?>
            <div class="box">
           <table>
           <caption>Following items are less in quantity</caption>
            <tr>
                <th>Item ID.</th>
                <th>Item Name</th>
                <th>Cost Price</th>
                <th>Selling Price</th>
                <th>MRP</th>
                <th>Quantity</th>
                <th>Supplier</th>
            </tr>
            <?php 
            echo $tr;
            echo '</table></div>';
           }
            ?>
           
        
    </section>
</body>
</html>