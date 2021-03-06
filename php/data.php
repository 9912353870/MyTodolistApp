<?php
 require("config.php");
 $data = array();
 function produkt_options($options, $default, $selected = null){
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
 $data['categories'] = array("",
                             "Automation-testing",
                             "Bug: design",
                             "Bug: functional",
                             "Bug: regression",
                             "Change request: design",
                             "Change request: functional",
                             "Change request: infrastructure",
                             "Documentation: development",
                             "Documentation: project management",
                             "Documentation: testing",
                             "Feature/Story: design",
                             "Feature/Story: functional",
                             "Feature/Story: infrastructure",
                             "Performance testing",
                             "Research",
                             "Security testing"
                            ) ;
 unset($data['categories'][0]);
  $data['status'] = array("", 
                          "In progress",
                          "Testing",
                          "Completed",
                         );
 unset($data['status'][0]);
  $sql = "SELECT id, username, mail FROM users";
  $result = mysqli_query($link, $sql);

  if (mysqli_num_rows($result) > 0) {
     while($row = mysqli_fetch_assoc($result)) {
        $data['users'][$row['id']] = $row['username'];
        $data['mail'][$row['id']] = $row['mail'];
     }
  } else {
       $data['users'] = array();
  }
?>