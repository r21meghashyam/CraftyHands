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
<?php 
                        
    $result = mysqli_query($DB['connection'],"select * from employees where emp_id=".$_GET['id']);
    $row = mysqli_fetch_array($result);
    if(!$row)
        die();
?>
<body>
    <header>
        <a href="/" style="text-decoration:none;color:#fff">CraftyHands</a>
    </header>
    <section>
        <div class="box">
            <form action="update.php" method="post">
                <div class="header">Edit Employee </div>
                <div class="body">
                    <div class="input">
                        <label>Employee Name:</label>
                        <input type="text" name="emp_name" value="<?php echo $row['emp_name']; ?>" required />
                    </div>
                    <div class="input">
                        <label>Date of join:</label>
                        <input type="date" name="date_of_join" value="<?php echo $row['date_of_join']; ?>" required />
                    </div>
                    <div class="input">
                        <label>Designation:</label>
                        <select name="designation" >
                            <option <?php echo $row['designation']=="Accountant"?"selected":""; ?>>Accountant</option>
                            <option <?php echo $row['designation']=="Billing"?"selected":""; ?>>Billing</option>
                        </select>
                    </div>
                    <div class="input">
                        <label>Salary:</label>
                        <input type="number" value="<?php echo $row['salary']; ?>" name="salary" min="0" required />
                    </div>
                    <div class="input">
                        <label>Username:</label>
                        <input type="text" value="<?php echo $row['username']; ?>" name="username" required />
                    </div>
                    
                    <div class="button">
                        <input type="hidden" name="emp_id" value="<?php echo $row['emp_id'];?>">

                        <button>Update</button>
                    </div>
                </div>
            </form>
        </div>
    </section>
    
</body>
</html>