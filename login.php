<?php  
session_start();
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: welcome.php");
    exit;
}

require_once"config.php";
$username = $password = "";
$username_error = $password_error = $login_error = "";
if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(empty(trim($_POST["username"]))){
        $username_error = "This Field Is Required!";
    }else{
        $username = trim($_POST["username"]);
    }
    if(empty(trim($_POST["password"]))){
        $password_error = "This Field Is Required!";
    }else{
        $password = trim($_POST["password"]);
    }
    if(empty($username_error) && empty($password_error)){
        $sql = "select id, username, password from users where username = ?";
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            $param_username = $username;
            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);
                if(mysqli_stmt_num_rows($stmt) == 1){
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            session_start();
                            $_SESSION["logggedin"] = true;
                            $_SESSION["id"] = $id;
                           
                            $_SESSION["username"] = $username;

                            header("location: welcome.php");
                         
                            
                        }else{
                            $login_error = "Invalid Username or Password!";
                        }
                    }
                }else{
                    $login_error = "Invalid Username or Password!";
                }
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
    <title>SIGN IN</title>
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
        <h2>Sign In</h2>
        <p>Enter Username and Password to Log In Your Account</p>
        <hr>
        <?php  
        if(!empty($login_error)){
            echo '<div class="alert alert-danger">'.$login_error.'</div>';
        }
        
        
        ?>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
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
        
            <div class="form-group" style="margin-top: 7px">
              
                <input type="submit" class="btn btn-primary" value="Log In">
               
            </div>
        </form>
        <p>Don't have an account? <a href="index.php">SignUP here</a></p>
    </div>
    
</body>
</html>