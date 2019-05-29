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
                <div class="header">Quotation </div>
                <div class="body">
                    <div class="input">
                        <label>Supplier:</label>
                        <select name="supplier_id" class="inline" onchange="getItems(this.value)" required >
                            <option></option>
                            <?php
                                $result = mysqli_query($DB['connection'],"select * from suppliers");
                                while($row=mysqli_fetch_array($result)){
                                    echo '<option value="'.$row['supplier_id'].'">'.$row['supplier_name'].'</option>';
                                }
                            ?>
                        </select>
                    </div>
                    <div class="input">
                        <label>Select item:</label>
                        <select id="items" class="inline" >
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
                    <div style="padding:20px">
                     Total: <span id="amount">Rs. 0.00</span>
                    </div>
                    <div class="button">
                        <button>Create</button>
                    </div>
                </div>
            </form>
        </div>
    </section>
    <script>
        let ITEMS=[];
        async function getItems(id){
            let response = await fetch("../api/items.php?supplier_id="+id);
            let json = await response.json();
            let options = '';
            ITEMS=json;
            ITEMS.map(item=>{
                options+=`<option value="${item.item_id}">${item.item_name}</option>`
            })
            let item = document.querySelector("#items");
            item.innerHTML=options;
        }
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
           input.addEventListener('change',e=>{
               
            let quantity = e.target.value;
            let itemTotal = document.querySelector(`#total_${item.item_id}`);
            itemTotal.value="Rs. "+(Number(item.item_cost_price)*Number(quantity)).toFixed(2);
            getTotal();
           });
           input.setAttribute('required','');
           input.value=1
           input.name='item_quantity[]';
           td.append(input);
           tr.append(td);

           td=document.createElement('td');
           input =document.createElement('input');
           input.setAttribute('readonly','');
           input.value='Rs. '+item.item_cost_price
           td.append(input);
           tr.append(td);


           td=document.createElement('td');
           input =document.createElement('input');
           input.setAttribute('readonly','');
           input.value='Rs. '+item.item_cost_price
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
            console.log(total);
            document.querySelector("#amount").innerHTML="Rs. "+total.toFixed(2);
        }
    </script>
</body>
</html>