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
                <th>Quotation No.</th>
                <th>Supplier Name</th>
                <th>Date</th>
                <th>Items</th>
                <th>Price</th>
                <th>Action</th>
            </tr>
            <?php 
            
                $result = mysqli_query($DB['connection'],
                "
                select 
                    qm.quotation_id,
                    supplier_name,
                    date,
                    count(*) as items,
                    sum(item_cost_price*qs.quantity) as price
                from 
                    quotationsMaster qm,
                    suppliers s,
                    quotationsSlave qs,
                    items i 
                where 
                    s.supplier_id=qm.supplier_id
                and qm.quotation_id=qs.quotation_id
                and qs.item_id=i.item_id
                group by qm.quotation_id");
                checkFail();
                while($row = mysqli_fetch_array($result)){
                   
                    echo '<tr>
                        <th>'.$row['quotation_id'].'</th>
                        <th>'.$row['supplier_name'].'</th>
                        <th>'.$row['date'].'</th>
                        <th>'.$row['items'].'</th>
                        <th>'.$row['price'].'</th>
                        <th>
                            <a href="view.php?id='.$row['quotation_id'].'">View</a>
                        </th>
                    </tr>';
                }
            ?>
           </table>
        </div>
    </section>
</body>
</html>