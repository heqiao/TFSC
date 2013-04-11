<?php
require_once "_parts/functions.php";
//require_once "_parts/db_settings.php";

// HTML parts
require_once "_parts/html_head.php";
require_once "_parts/header.php";
?>
<!doctype html>
<html lang="en">
<head></head>
<div class="container">
  <div class="row-fluid">
    <!-- Form to post data-->
    <div class="span7 offset2">
        <h3><center>Teaching Assistant Luncheon Survey</center></h3>
        <p><strong>Food for Thought: </strong>The TFSC Co-Directors are looking for feedback converning our programming.
          We gave ou food, you give us thoughts. (See, there really is no such thing as a free lunch!)</p>
         <form id="form" name="form" method= "POST" action="<?php echo $_SERVER['PHP_SELF'];?>">
          <?php
            //Connection string 
            $connection = mysql_connect("localhost","root", "");
            //Run the connection string to connecct to the databse
            mysql_select_db("tfscdb", $connection) or die("Cannot open the database");
            //set variable query for a query statement
            $query = "select description, question_id, question_flag, number_of_choices from question where event_type = 'TA' order by 'order';";  
            //execute the query           
            $result = mysql_query($query, $connection) or die ("Could not execute sql: $query");
            // get result record
            $num_rows = mysql_num_rows($result);

            $check = true; 
            //read questions from database
            for($i=0;$i<$num_rows;$i++)
            {
                $row = mysql_fetch_array($result);
                $number = $i + 1;
                echo "<p>".$number.". ".$row['description']."</p>"; 
                //validation
                if (isset($_POST['submit'])) {    
                       if (!isset($_POST[$row['question_id']]))  
                       {
                         echo "<div class='alert alert-error'>Please answer this question.</div>";                    
                         $check = false;
                       }                                    
                   }               
                //determine question format according to question flag
                if($row['question_flag'] == 'R')
                {
                  if ($row['number_of_choices'] == 2) 
                  {
                    echo "<label class='radio'><input type = 'radio' name = '$row[question_id]' value = '1'";
                    if ($_POST[$row['question_id']] == '1') 
                      echo "checked";
                    echo "> Yes </label>";
                    echo "<label class='radio'><input type = 'radio' name = '$row[question_id]' value = '2'";
                    if ($_POST[$row['question_id']] == '2') 
                      echo "checked";
                    echo "> No </label>";
                  }                  
                  else
                  {
                    for ($j=0; $j < $row['number_of_choices']; $j++) 
                    { 
                      $rate = $j+1;
                      echo "<label class='radio'><input type = 'radio' name ='$row[question_id]' value = '$rate'";
                      if ($_POST[$row['question_id']] == $rate) 
                        echo "checked";
                      echo ">".$rate."</label>";
                    }
                  }                
                } 
                else if ($row['question_flag'] == 'C') 
                {
                  echo "<textarea class = 'span12' name ='$row[question_id]' placeholder = 'Comments here...'></textarea>";                 
                }                        
            }
            insert data into database
            if (isset($_POST['submit'])) {
              if ($check == true){
                //execute the query           
                $result = mysql_query($query, $connection) or die ("Could not execute sql: $query");
                // get result record
                $num_rows = mysql_num_rows($result);
                //insert each line of answer
                for ($j=0; $j<$num_rows ; $j++) { 
                  $row = mysql_fetch_array($result);                  
                  $answer = $_POST[$row['question_id']];
                  if ($row['question_flag'] == 'R'){
                    $sql = "insert into evaluation (`Evaluation_ID`, `Question_ID`, `Event_ID`, `Session_ID`, `User_Rating`, `User_Comment`) values(null, $row[question_id], 3, null, $answer, null);";
                  }else if ($row['question_flag'] == 'C') {
                    if ($answer != null) {
                      $sql = "insert into evaluation (`Evaluation_ID`, `Question_ID`, `Event_ID`, `Session_ID`, `User_Rating`, `User_Comment`) values(null, $row[question_id], 3, null, null, '$answer');";
                    }else{
                      $sql = "insert into evaluation (`Evaluation_ID`, `Question_ID`, `Event_ID`, `Session_ID`, `User_Rating`, `User_Comment`) values(null, $row[question_id], 3, null, null, '');";                     
                    }
                  }  
                  $insert = mysql_query($sql, $connection) or die ("Could not excute sql $sql");                   
                }
                header("Location: thanks.php");
              }    
            }
          ?>
          <center><button class ="btn" name = "submit"/>Submit</button></center>
        </form>       
    </div>    
  </div>
</div>
<?php require_once "_parts/html_foot.php";?>
</body>
</html>