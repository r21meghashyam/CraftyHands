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
                <th>Bill No.</th>
                <th>Customer Name</th>
                <th>Date</th>
                <th>Items</th>
                <th>Bill Amount</th>
                <th>Type</th>
                <th>Action</th>
            </tr>
            <?php 
            
                $result = mysqli_query($DB['connection'],
                "
                select 
                    bm.bill_id,
                    customer_name,
                    date,
                    count(bs.item_id) as items,
                    amount,
                    type
                from 
                    billingMaster bm,
                    billingSlave bs,
                    items i 
                where 
                 bm.bill_id=bs.bill_id
                and bs.item_id=i.item_id
                group by bm.bill_id");
                checkFail();
                while($row = mysqli_fetch_array($result)){
                   
                    echo '<tr>
                        <th>'.$row[0].'</th>
                        <th>'.$row[1].'</th>
                        <th>'.$row[2].'</th>
                        <th>'.$row[3].'</th>
                        <th>'.$row[4].'</th>
                        <th>'.$row[5].'</th>
                        <th>
                            <a href="view.php?id='.$row['bill_id'].'&type='.$row[5].'">View</a>
                        </th>
                    </tr>';
                }
            ?>
           </table>
        </div>
    </section>
</body>
</html>