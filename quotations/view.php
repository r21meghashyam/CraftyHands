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
            
           <table>
            <tr>
                <th>Item No</th>
                <th>Item Name</th>
                <th>Item Cost Price</th>
                <th>Quantity</th>
                <th>Price</th>
            </tr>
            <?php 
            
                $result = mysqli_query($DB['connection'],
                "
                select 
                    qs.item_id,
                    item_name,
                    item_cost_price,
                    qs.quantity,
                    item_cost_price*qs.quantity as price
                from 
                    quotationsSlave qs,
                    items i 
                where 
                qs.item_id=i.item_id and quotation_id=".$_GET['id']);
                checkFail();
                while($row = mysqli_fetch_array($result)){
                   
                    echo '<tr>
                        <th>'.$row['item_id'].'</th>
                        <th>'.$row['item_name'].'</th>
                        <th>'.$row['item_cost_price'].'</th>
                        <th>'.$row['quantity'].'</th>
                        <th>'.$row['price'].'</th>
                       
                    </tr>';
                }
            ?>
           </table>
        </div>
    </section>
</body>
</html>