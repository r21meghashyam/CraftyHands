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
        
    </style>
</head>
<body>
    <header>
        <a href="/" style="text-decoration:none;color:#fff">CraftyHands</a>
    </header>
    <section>
        <h1>Bills Management</h1>
        <div class="options">
            <a href="generate.php">Generate Bill</button>
            <a href="list.php">List Bills</button>
            <a href="../">Home</button>
        </div>
    </section>
</body>
</html>