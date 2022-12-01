<?php 

$username = $password = $confirm_password = "";
$username_error = $password_error = $confirm_password_error = "";
require_once"config.php";
if($_SERVER["REQUEST_METHOD"] == "POST"){
    //Initialising Username
   if(empty(trim($_POST["username"]))){
    $username_error = "This Field Is Required!";
   }else{
    $sql = "select id from users where username = ?";
    if($stmt = mysqli_prepare($link, $sql)){
        mysqli_stmt_bind_param($stmt,"s", $param_username);
        $param_username = trim($_POST["username"]);
        if(mysqli_stmt_execute($stmt)){
            mysqli_stmt_store_result($stmt);
            if(mysqli_stmt_num_rows($stmt) == 1){
                $username_error = "This name is already taken!";
            }else{
                $username = trim($_POST["username"]);
            }
        }else{
            echo "Oops! Something went wrong, please try again!";
        }
        mysqli_stmt_close($stmt);
    }
   }
    //Initialising password
  if(empty(trim($_POST["password"]))){
    $password_error = "This Field Is Required!";
  }elseif (strlen(trim($_POST["password"])) < 8) {
    $password_error = "Password Too Short!";
  }else{
    $password = trim($_POST["password"]);
  }
  if(empty(trim($_POST["confirm_password"]))){
    $confirm_password_error = "This Field Is Required!";
  }else{
    $confirm_password = trim($_POST["confirm_password"]);
    if(empty($password_error) && ($password != $confirm_password)){
        $confirm_password_error = "Password Did Not Match!";
    }
  }
  if(empty($username_error) && empty($password_error) && empty($confirm_password_error)){
    $sql = "insert into users(username, password) values(?, ?)";
    if($stmt = mysqli_prepare($link, $sql)){
        mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);
        $param_username = $username;
        $param_password = password_hash($password, PASSWORD_DEFAULT);
        if(mysqli_stmt_execute($stmt)){
            header("location: login.php");
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
    <title>SIGN UP</title>
    <link rel="stylesheet" href="css/bootstrap.css">
    <style>
        body{
            font-weight: 14px;

        }
        .container{
            padding: 20px;
            margin-top: 50px;
            width: 360px;
        }
        .container input{
            width: 300px;

        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Sign Up</h2>
        <p>Please Fill Up the form below to create your new account</p>
        <form action="#" method="POST">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" name="username" class="form-control <?php echo(!empty($username_error))? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                <span class="invalid-feedback"><?php echo $username_error; ?></span>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" class="form-control <?php echo(!empty($password_error))? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
                <span class="invalid-feedback"><?php echo $password_error; ?></span>
            </div>
            <div class="form-group">
                <label for="confirm_password">confirm_password</label>
                <input type="password" name="confirm_password" class="form-control <?php echo(!empty($confirm_password_error))? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?>">
                <span class="invalid-feedback"><?php echo $confirm_password_error; ?></span>
            </div>
            <div class="form-group" style="margin-top: 7px">
              
                <input type="submit" class="btn btn-primary" value="Sign Up">
               
            </div>
        </form>
        <P>Already have an account? <a href="login.php">Login here</a></P>
    </div>
    
</body>
</html>