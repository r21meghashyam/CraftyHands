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

        .loginbox{
            padding: 20px;
            background: #900;
            color:#fff;
        }
        .loginbox .header{
            text-align:center;
            font-size:20px;
        }
        .loginbox>*{
            padding:10px;
        }
        .loginbox input{
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
        <div class="loginbox">
            <form action="submit.php" method="post">
                <div class="header">Login</div>
                <div class="body">
                    <div class="input">
                        <label>Username:</label>
                        <input type="text" name="username"/>
                    </div>
                    <div class="input">
                        <label>Password:</label>
                        <input type="password" name="password" />
                    </div>
                    <div class="button">
                        <button>Login</button>
                    </div>
                </div>
            </form>
        </div>
    </section>
</body>
</html>