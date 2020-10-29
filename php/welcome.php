<?php

session_start();
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
$str = htmlspecialchars($_SESSION["username"]);
$words = explode(' ', $str);
$result = $words[0][0]. $words[1][0];

$output = '<!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <title>Welcome</title>
                <link href="css/welcome.css" rel="stylesheet">
            </head>
            <body>
                <div class="page-header">
                    <div class="usr-title" ><span class="usr-icon" >'.$result.'</span>'.$str.'</div>
                    <div class="logout">
                      <a href="logout.php" style="text-decoration: none;color: red;" class="btn btn-danger">logout</a>
                    </div>
                </div>
                <div class="outer-container" >
                  <div class="inner-container" >
                    <div class="create option"></div>
                    <div class="action-btns">
                      <a href="add_todo.php" style="text-decoration: none;color: black;">Create todo</a>
                    </div>
                  </div>
                  <div class="inner-container" >
                    <div class="view option"></div>
                    <div class="action-btns">
                      <a href="view_todos.php" style="text-decoration: none;color: black;padding: 4px 52px;">View todo list</a>
                    </div>
                  </div>
                </div> 
            </body>
            </html>';
echo $output;
?>