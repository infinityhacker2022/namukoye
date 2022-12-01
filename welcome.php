<?php  
session_start();



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <link rel="stylesheet" href="css/bootstrap.css">
    <style>
        body{
            font-size: 17px;
        }
        .container{
            margin-top: 80px;
            padding: 20px;

        }
        .container input{
            width: 310px;

        }
    </style>
</head>
<body>
    <div class="container">
        <h3>Hi, <?php echo(htmlspecialchars($_SESSION["username"])) ?>. Welcome Home!</h3>
        <p>
            <a href="reset.php" class="btn btn-primary" >Reset Password</a>
            <a href="logout.php" class="btn btn-warning">Log Out</a>
        </p>
    </div>
    
</body>
</html>