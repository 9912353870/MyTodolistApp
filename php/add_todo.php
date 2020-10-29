<?php 
session_start();
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
require("data.php");
require("config.php");
$post = array();
$tid = "";
if($_SERVER["REQUEST_METHOD"] == "GET" && is_numeric($_GET['tid'])){
  $tid = $_GET['tid'];
  $post['edit'] = $_GET['tid'];
  $sql = "Select title,assignee,estimated,completed,categories,status from todo_details where sno = ? ";
      
  if($stmt = mysqli_prepare($link, $sql)){
      mysqli_stmt_bind_param($stmt, "s", $param);
      $param = $_GET['tid'];
      
      if(mysqli_stmt_execute($stmt)){
          mysqli_stmt_store_result($stmt);
          
          if(mysqli_stmt_num_rows($stmt) == 1){  
              mysqli_stmt_bind_result($stmt,$title,$assignee,$estimated,$completed,$categories,$status);
              if(mysqli_stmt_fetch($stmt)){
                $post['todo-title'] = $title;
                $post['assinee'] = $assignee;
                $est_time = explode(":",$estimated);
                $com_time = explode(":",$completed);
                $post['estimated']['hrs'] = $est_time[0];
                $post['estimated']['mins'] = $est_time[1];
                $post['completed']['hrs'] = $com_time[0];
                $post['completed']['mins'] = $com_time[1];
                $post['categories'] = $categories;
                $post['task-status'] = $status;
              }
            }
        }   
       mysqli_stmt_close($stmt);
   }
}elseif($_SERVER["REQUEST_METHOD"] == "POST"){
$post = array();
  if( !empty($_POST['edit']) && $_POST['edit'] > 0){
    $sql = "UPDATE todo_details SET title = ?, assignee = ?, estimated = ?, completed = ?, categories = ?, status = ?,udate = ?
            WHERE sno = ".$_POST['edit']."";
  }else{
  $sql = "INSERT INTO todo_details(title, assignee, estimated, completed, categories, status,cdate)
          VALUES ( ?, ?, ?, ?, ?, ?, ?)";
  }
 
    $post = $_POST;
  if($stmt = mysqli_prepare($link,$sql)){
    mysqli_stmt_bind_param($stmt,'sssssss',$title,$assinee,$tot_est,$tot_com,$category,$status,$cdate);
    
    $title = (!empty($post['todo-title']) && $post['todo-title'] != "") ? $post['todo-title'] : "";
    $assinee = (!empty($post['assinee']) && $post['assinee'] != "") ? $post['assinee'] : "";
    $est_hrs = (!empty($post['estimated']['hrs']) && $post['estimated']['hrs'] != "") ? $post['estimated']['hrs'] : "";
    $est_mins = (!empty($post['estimated']['mins']) && $post['estimated']['mins'] != "") ? $post['estimated']['mins'] : "";
    $com_hrs = (!empty($post['completed']['hrs']) && $post['completed']['hrs'] != "") ? $post['completed']['hrs'] : "";
    $com_mins = (!empty($post['completed']['mins']) && $post['completed']['mins'] != "") ? $post['completed']['mins'] : "";
    $tot_est = $est_hrs.":".$est_mins.":"."00";
    $tot_com = $com_hrs.":".$com_mins.":"."00";
    $category = (!empty($post['categories']) && $post['categories'] != "") ? $post['categories'] : "";
    $status = (!empty($post['task-status']) && $post['task-status'] != "") ? $post['task-status'] : "";
    $cdate = date("d-m-Y h:i:sa");
  
         if(mysqli_stmt_execute($stmt)){
             header("location: welcome.php");
         } else{
             echo "Something went wrong. Please try again later.";
         }
         mysqli_stmt_close($stmt);
  }
    mysqli_close($link);
    
}
function getTime($type,$post){
  
  $output = '';
  $output .= '<select name="'.$type.'[hrs]" style="width:50px!important;margin-right:10px;font-size:10px;" required >';
  $output .= '<option value="">Hrs</option>';
  for($i=0;$i<24;$i++){
     $time = (strlen($i) == 1) ? '0'.$i : $i;
     $selected = ($post[$type]['hrs'] == $time) ? 'selected="selected"' : '';
     $output .= '<option value="'.$time.'" '.$selected.' >'.$time.'</option>';
  }
  $output .= '</select>';
  $output .= '<select name="'.$type.'[mins]" style="width:50px!important;font-size:10px;" required >';
  $output .= '<option value="">Min</option>';
  for($i=0;$i<60;$i++){
      if($i%5 == 0) {
         $time = (strlen($i) == 1) ? '0'.$i : $i;
         $selected = ($post[$type]['mins'] == $time) ? 'selected="selected"' : '';
         $output .= '<option value="'.$time.'" '.$selected.' >'.$time.'</option>';
      }
  }
  $output .= '</select>';
  return $output;
}
function produkt_options($options, $default, $selected = null)
{
    $output = array();
    foreach ($default as $key => $name) {
        $output[] = '<option value="'.$key.'" '.$selValue.'>'.$name.'</option>';
    }
    foreach ($options as $key => $name) {
        $selValue = ($key == $selected & is_numeric($selected))? 'selected="selected"' : '';
        $output[] = '<option value="'.$key.'" '.$selValue.'>'.$name.'</option>';
    }
    return implode('', $output);
}

$str = htmlspecialchars($_SESSION["username"]);
$words = explode(' ', $str);
$result = $words[0][0]. $words[1][0];
//print_r($data);exit;
$output = '<!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <title>Create todo</title>
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
                 <form action="'.htmlspecialchars($_SERVER["PHP_SELF"]).'" method="post" class="td-form">
                     <div class="field-content-wrapper">
                        <label for="todo-title"><b>Task Title</b></label>
                       <input type="text" placeholder="Enter todo title" value="'.$post['todo-title'].'" name="todo-title" id="ttile" required >
                     </div>
                     <div class="field-content-wrapper">
                        <label for="assignee"><b>Assign to</b></label>
                        <select name="assinee" required>
                          '.produkt_options($data['users'], array(""=>"Select"),$post['assinee']).'
                        </select>
                    </div>
                    <div class="field-content-wrapper">
                      <div class="time-flds " >
                        <label for="assignee"><b>Estimated time(in hrs)</b></label>
                        '.getTime("estimated",$post).'
                      </div>
                      <div class="time-flds " >
                        <label for="assignee"><b>Completed time(in hrs)</b></label>
                        '.getTime("completed",$post).'
                      </div>
                    </div>
                    <div class="field-content-wrapper">
                        <label for="assignee"><b>Categories</b></label>
                        <select name="categories" required >
                        '.produkt_options($data['categories'], array(""=>"Select"), $post['categories']).'
                        </select>
                    </div>
                    <div class="field-content-wrapper">
                        <label for="assignee"><b>Task status</b></label>
                        <select name="task-status" required >
                        '.produkt_options($data['status'], array(""=>"Select"), $post['task-status']).'
                        </select>
                    </div>
                    <div class="field-content-wrapper">
                       <a href="welcome.php" >Back</a>
                       <button type="submit" class="form-submit">Submit</button>
                    </div>
                    <input type="hidden" name="edit" value="'.$post['edit'].'" /> 
                 </form>
                 <div></div>
                </div> 
            </body>
            </html>';
echo $output;
?>