<?php  
session_start();
$password = $confirm_password = $msg_success = "";
$password_error = $confirm_password_error = "";
require_once"config.php";
if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(empty(trim($_POST["password"]))){
        $password_error = "Please Enter Password!";
    }elseif(strlen(trim($_POST["password"])) < 8){
        $password_error = "Password is too short!";
    }else{
        $password = trim($_POST["password"]);
    }
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_error = "Please Confirm Your Password!";
    }else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_error) && ($password != $confirm_password)){
            $confirm_password_error = "Your Password Did Not Match!";
        }
    }
    if(empty($password_error) && empty($confirm_password_error)){
        $sql = "update users set password=? where id = ?";
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "si", $param_password, $param_id);
            $param_password = password_hash($password, PASSWORD_DEFAULT);
            $param_id = $_SESSION["id"];
            if(mysqli_stmt_execute($stmt)){
                header("location: login.php");
                exit();
            }else{
                echo "Oops! Something went wrong, try again later!";
            }
            mysqli_stmt_close($stmt);
        }
    }
    mysqli_close($link);
}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RESET PASSWORD</title>
    <link rel="stylesheet" href="css/bootstrap.css">
    <style>
        body{
            font-size: 18px;
        }
        .container{
            width: 300px;
            padding: 20px;
        }
        .container input, a{
            width: 310px;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>PASSWORD RESET</h2>
        <p>Please Complete the form below to reset your password!</p>
        <hr>
      
        <form action="#" method="POST">
            <div class="form-group">
                <label for="password">Enter New Password</label>
                <input type="password" name="password" class="form-control <?php echo(!empty($password_error))? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
                <span class="invalid-feedback"><?php echo $password_error; ?></span>
            </div>
            <div class="form-group">
                <label for="confirm_password">Confirm New Password</label>
                <input type="password" name="confirm_password" class="form-control <?php echo(!empty($confirm_password_error))? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?>">
                <span class="invalid-feedback"><?php echo $confirm_password_error; ?></span>
            </div>
            <div class="form-group" style="margin-top: 6px;">
                <input type="submit" class="btn btn-primary" value="Reset Now" style="margin-top: 4px;">
                <a href="welcome.php" class="btn btn-primary" style="margin-top: 4px;">Cancel</a>
            </div>
        </form>
    </div>
    
</body>
</html>