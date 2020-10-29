<?php 
 session_start();
 if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
     header("location: login.php");
     exit;
 }
 require("data.php");
 require("config.php");
 function generateTodoList($link,$data,$post){
    $users = $data['users'];
    $categories = $data['categories'];
    $status = $data['status'];
    $sql = " SELECT * FROM todo_details where sno > 0 ";
    if(!empty($post) && $post['search'] == 1){
       
       $a = isset($post['assinee']) && $post['assinee'] != "" ? $post['assinee'] : 0;
       $c = isset($post['category']) && $post['category'] != "" ? $post['category'] : 0; 
       $s = isset($post['status']) && $post['status'] != "" ? $post['status'] : 0;
      
        $sql .= ($a != 0) ? 'AND assignee = "'.$a.'" ' : '';
     
        $sql .=  ($c != 0) ? 'AND categories = "'.$c.'" ' : '';
       
        $sql .= ($s != 0) ? 'AND status = "'.$s.'" ' : '';
       
    }
    
    $result = mysqli_query($link, $sql);
    $todolist = array();
    if (mysqli_num_rows($result) > 0) {
     while($row = mysqli_fetch_assoc($result)) {
        $todolist[$row['sno']]['title'] = $row['title'];
        $todolist[$row['sno']]['assignee'] = $row['assignee'];
        $todolist[$row['sno']]['estimated'] = $row['estimated'];
        $todolist[$row['sno']]['completed'] = $row['completed'];
        $todolist[$row['sno']]['categories'] = $row['categories'];
        $todolist[$row['sno']]['status'] = $row['status'];
       }
    } else {
        $todolist = array();
    }
   $table  = '';
   $table .= '<table id="customers">';
   $table .= '<tr>
                <th>Title</th>
                <th>Asignee</th>
                <th>Estimated time</th>
                <th>Completed time</th>
                <th>Category</th>
                <th>Status</th>
                <th>Action</th>
             </tr>';
   if(empty($todolist)){
    $table .= '  <tr>
                  <td colspan = "7" >
                      No Search result found....!
                  </td>
                 </tr>';
   }
   foreach($todolist AS $tid => $val){
      $table .= '<tr>
                  <td>'.$val['title'].'</td>
                  <td>'.$users[$val['assignee']].'</td>
                  <td>'.$val['estimated'].'</td>
                  <td>'.$val['completed'].'</td>
                  <td>'.$categories[$val['categories']].'</td>
                  <td>'.$status[$val['status']].'</td>
                  <td><a href="add_todo.php?tid='.$tid.'" >Edit</a></td>
                </tr>';
   }          
   $table .= '  <tr>
                  <td colspan = "7" >
                      <a href="welcome.php" >Back</a>
                  </td>
                </tr>';
   $table .= '</table>';
   return $table;
 }
 $post = array();
 if($_SERVER["REQUEST_METHOD"] == "POST"){
   $post = $_POST;
   $post['search'] = 1;
 }
$str = htmlspecialchars($_SESSION["username"]);
$words = explode(' ', $str);
$result = $words[0][0]. $words[1][0];

 $output = '';
 $output .= '<!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <title>View todo list</title>
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
                   <div style="float: left;display: block;margin: 5px 10px;">
                    <form action="'.htmlspecialchars($_SERVER["PHP_SELF"]).'" method="post" class="search-form">
                        <div class="field_search_wrapper">
                           <label for="assignee"><b>Assign to</b></label>
                           <select name="assinee" >
                             '.produkt_options($data['users'], array(""=>"Select"),$post['assinee']).'
                           </select>
                        </div> 
                        <div class="field_search_wrapper">
                           <label for="category"><b>Categories</b></label>
                           <select name="category" >
                             '.produkt_options($data['categories'], array(""=>"Select"),$post['category']).'
                           </select>
                        </div> 
                        <div class="field_search_wrapper">
                           <label for="status"><b>Status</b></label>
                           <select name="status" >
                             '.produkt_options($data['status'], array(""=>"Select"),$post['status']).'
                           </select>
                        </div> 
                        <input type="hidden" name="edit" value="'.$post['search'].'" />
                        <div class="field_search_wrapper" style="margin-top: 25px;">
                            <button type="submit" class="form-submit">Search</button> 
                        </div>
                    </form>
                </div>
                  <div>'.generateTodoList($link,$data,$post).'</div>
                </div> 
            </body>
            </html>';
echo $output;
 
?>

