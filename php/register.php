<?php 
 require "config.php";
 $email= $username = $password = $confirm_password = "";
 $email_err = $username_err = $password_err = $confirm_password_err = "";
 
if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(empty(trim($_POST["email"]))){
        $email_err = "Please enter your email id.";
    } else{
        $sql = "SELECT id FROM users WHERE mail = ?";
        if($stmt = mysqli_prepare($link, $sql)){
            $param_mail = trim($_POST["email"]);
            mysqli_stmt_bind_param($stmt, "s", $param_mail);
            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $email_err = "This email is already taken.";
                } else{
                    $email = trim($_POST["email"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
            mysqli_stmt_close($stmt);
        }
    }
   
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";     
    } else{
        $username = trim($_POST["username"]);
    }

    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }
   
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
    
    if(empty($email_err) && empty($username_err) && empty($password_err) && empty($confirm_password_err)){
        $sql = "INSERT INTO users (username, password, mail) VALUES (?, ?, ?)";
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "sss", $param_username, $param_password, $param_mail);
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT);
            $param_mail = $email;
            if(mysqli_stmt_execute($stmt)){
                header("location: login.php");
            } else{
                echo "Something went wrong. Please try again later.";
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
                        <h1>Register</h1>
                        <p>Please fill in this form to create an account.</p>
                        <hr>
                        
                        <label for="email"><b>Email</b></label><span class="form-err" >'.$email_err.'</span>
                        <input type="text" placeholder="Enter Email" name="email" id="email" required >

                        <label for="email"><b>Username</b></label><span class="form-err" >'.$username_err.'</span>
                        <input type="text" placeholder="Enter username" name="username" id="username" required >
                        
                        <label for="psw"><b>Password</b></label><span class="form-err" >'.$password_err.'</span>
                        <input type="password" placeholder="Enter Password" name="password" id="psw" required >
                    
                        <label for="psw-repeat"><b>Repeat Password</b></label><span class="form-err" >'.$confirm_password_err.'</span>
                        <input type="password" placeholder="Repeat Password" name="confirm_password" id="psw-repeat" required >
                        <hr>
                        <div style="display: flex;" >
                            <button type="submit" class="registerbtn">Register</button>
                            <button type="button" class="registerbtn" style="background-color: #e70202;color: white;">
                              <a  style="text-decoration: none;color: white;padding: 15px 110px;" href="login.php">Sign in</a>
                            </button>
                        </div>
                      </div>
                     
                    </form>
                   </div>';    
  $output .= ' </body>
              </html>';       
 echo $output;
?>
