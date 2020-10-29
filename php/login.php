<?php 
session_start();
 
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: welcome.php");
    exit;
}
 
require_once "config.php";
 
$username = $password = "";
$username_err = $password_err = "";
 
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter Email id.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    if(empty($username_err) && empty($password_err)){
        $sql = "SELECT id, username, password FROM users WHERE mail = ?";
        
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
                            
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;                            
                            
                            
                            header("location: welcome.php");
                        } else{
                            $password_err = "The password you entered was not valid.";
                        }
                    }
                } else{
                    $username_err = "No account found with that username.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            mysqli_stmt_close($stmt);
        }
    }
    
    mysqli_close($link);
}
$output  = '<!DOCTYPE html>
             <html>
               <head>
                <meta name="viewport" content="width=device-width, initial-scale=1">
                <link href="css/style.css" rel="stylesheet">
                </head>
                <body>';
 $output .= '      <div>
                    <form action="'.htmlspecialchars($_SERVER["PHP_SELF"]).'" method="post">
                       <div class="container">
                        <h1>Login</h1>
                        <hr>
                    
                        <label for="email"><b>Email</b></label><span class="form-err" >'.$username_err.'</span>
                        <input type="text" placeholder="Enter Email" name="username" id="email" required >
                        
                        <label for="psw"><b>Password</b></label><span class="form-err" >'.$password_err.'</span>
                        <input type="password" placeholder="Enter Password" name="password" id="psw" required >
                    
                        <button type="submit" class="registerbtn">Login</button>
                      </div>
                      
                      <div class="container signin">
                       <p>Dont have an account? <a href="register.php">Sign up now</a>.</p>
                      </div>
                    </form>
                   </div>';    
  $output .= ' </body>
              </html>';       
 echo $output;
?>