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
            margin:20px;
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
        .inline{
            width:auto!important;
        }
        table,th,td{
            border:1px solid #fff;
            border-collapse:collapse;
            padding:5px;
        }
        table input{
            max-width:90%;
        }
        input[readonly]{
            color:#FFF;
            background:transparent;
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
                <div class="header">Bill </div>
                <div class="body">
                    <div class="input">
                        <label>Buyer Type:</label>
                        <select name="buyer_type" class="inline" onchange="clearTable()" required>
                            <option>Vendors</option>
                            <option>Customers</option>
                        </select>
                    </div>
                    <div class="input">
                        <label>Customer Name:</label>
                        <input type="text" name="name" required />
                    </div>
                    <div class="input">
                        <label>Customer Contact:</label>
                        <input type="number" name="contact" required />
                    </div>
                    <div class="input">
                        <label>Select item:</label>
                        <select id="items" class="inline" >
                            <?php 
                                $result = mysqli_query($DB['connection'],"select * from items where item_quantity>0");

                                $array = Array();
                                 while($row = mysqli_fetch_array($result)){
                                     echo '<option value="'.$row['item_id'].'" >'.$row['item_name'].'</option>';
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
                            ?>
                        </select>
                        <button id="addItem">Add</button>
                    </div>
                    <table >
                        <tr>
                            <th>Item Id</th>
                            <th>Item Name</th>
                            <th>Item Quantity</th>
                            <th>Item Price</th>
                            <th>Total Price</th>
                        </tr>
                        <tbody id="itemsTable">
                        </tbody>
                    </table>
                    <div style="margin-top:20px">
                     Sub Total: <span id="subtotal">Rs. 0.00</span>
                    </div>
                    <div>
                    GST <?php echo $GLOBALS['gst']?>%: <span id="gst">Rs. 0.00</span>
                    </div>
                    <div>
                    Total: <span id="grandtotal">Rs. 0.00</span>
                    </div>
                    <div class="button">
                        <button>Create</button>
                    </div>
                </div>
            </form>
        </div>
    </section>
    <script>
        let ITEMS=JSON.parse('<?php echo $json;?>');
        let GST=<?php echo $GLOBALS['gst'];?>;
        let addItemButton = document.querySelector("#addItem");

        addItemButton.addEventListener("click",e=>{
            e.preventDefault();
            
            let items = document.querySelector("#items");
            
            let item_id = items.value;
            if(!item_id)
                return;
            let item = ITEMS.find(item=>item.item_id==item_id);
            
            if(document.querySelector(`[data="${item.item_id}"]`))
                return alert("Item already added!");
           
           let tr=document.createElement('tr');
           tr.classList.add("item");
           tr.setAttribute("data",item.item_id);
           
           let td=document.createElement('td');
           let input =document.createElement('input');
           input.setAttribute('readonly','');
           input.value=item.item_id
           input.name='item_id[]';
           td.append(input);
           tr.append(td);

           td=document.createElement('td');
           input =document.createElement('input');
           input.setAttribute('readonly','');
           input.value=item.item_name
           td.append(input);
           tr.append(td);

           td=document.createElement('td');
           input =document.createElement('input');
           input.type="number"
           input.min="1"
           input.max=item.item_quantity;
           input.addEventListener('change',e=>{
               
            let quantity = e.target.value;
            let itemTotal = document.querySelector(`#total_${item.item_id}`);
            let price = buyer=='Vendors'?item.item_selling_price:item.item_mrp;
            itemTotal.value="Rs. "+(Number(price)*Number(quantity)).toFixed(2);
            getTotal();
           });
           input.value=1
           input.name='item_quantity[]';
           input.setAttribute('required','');
           td.append(input);
           tr.append(td);

            let buyer = document.querySelector("[name='buyer_type']").value;
            let price = buyer=='Vendors'?item.item_selling_price:item.item_mrp;
           td=document.createElement('td');
           input =document.createElement('input');
           input.setAttribute('readonly','');
           input.value='Rs. '+price;
           td.append(input);
           tr.append(td);


           td=document.createElement('td');
           input =document.createElement('input');
           input.setAttribute('readonly','');
           input.value='Rs. '+price;
           input.id="total_"+item.item_id;
           td.append(input);
           tr.append(td);
           
            document.querySelector("#itemsTable").append(tr);
           getTotal();
        })

        function getTotal(){
            let total =0;
            let rows = document.querySelectorAll("[id^=total]");
            Array.from(rows).forEach(row=>total+=Number(row.value.replace("Rs.","").trim()));
            let subtotal = total;
            let gst = subtotal*GST/100;
            let grandtotal = subtotal+gst;
            document.querySelector("#subtotal").innerHTML="Rs. "+subtotal.toFixed(2);
            document.querySelector("#gst").innerHTML="Rs. "+gst.toFixed(2);
            document.querySelector("#grandtotal").innerHTML="Rs. "+grandtotal.toFixed(2);
        }

        function clearTable(){
            document.querySelector("#itemsTable").innerHTML="";
        }
    </script>
</body>
</html>