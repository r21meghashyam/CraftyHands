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
    </style>
</head>
<body>
    <header>
        <a href="/" style="text-decoration:none;color:#fff">CraftyHands</a>
    </header>
    <section>
        <div class="box">
            <form action="insert.php" method="post">
                <div class="header">Add Item</div>
                <div class="body">
                    <div class="input">
                        <label>Item Name:</label>
                        <input type="text" name="item_name" required />
                    </div>
                    <div class="input">
                        <label>Item Cost Price:</label>
                        <input type="text" name="item_cost_price" required  />
                    </div>
                    <div class="input">
                        <label>Item Selling Price:</label>
                        <input type="number" name="item_selling_price" required  />
                    </div>
                    <div class="input">
                        <label>Item MRP:</label>
                        <input type="number" name="item_mrp" required  />
                    </div>
                    <div class="input">
                        <label>Item quantity:</label>
                        <input type="number" name="item_quanity" required />
                    </div>
                    <div class="input">
                        <label>Supplier:</label>
                        <select name="supplier_id" required >
                        <?php 
                            $result = mysqli_query($DB['connection'],"select * from suppliers");
                            while($row=mysqli_fetch_array($result)){

                                echo '<option value="'.$row['supplier_id'].'">'.$row['supplier_name'].'</option>';
                            }
                        ?>
                        </select>
                    </div>
                    
                    <div class="button">
                        <button>Add</button>
                    </div>
                </div>
            </form>
        </div>
    </section>
</body>
</html>