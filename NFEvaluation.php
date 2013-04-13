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
<body>
<div class="container">
  <div class ="row-fluid">
    <div class = "span7 offset2 nf-form">
      <?php
            $encode = $_GET['id'];
                      
            $urlenc = new Encryption();           
            $id = $urlenc->decode("$encode");

            //Connection string 
            $connection = mysql_connect("localhost","root", "");
            //Run the connection string to connecct to the databse
            mysql_select_db("tfscdb", $connection) or die("Cannot open the database");
            //set variable query for a query statement
            $titleQuery = "select * from event where id = $id;";  
            //execute the query           
            $titleResult = mysql_query($titleQuery, $connection) or die ("Could not execute sql: $titleQuery");
            //get title
            $titleRow = mysql_fetch_array($titleResult);
            $bigTitle = $titleRow['name'];
      ?>  
        <!-- Form to post data-->
          <center><h3><?php echo $bigTitle;?> Survey</h3></center>
          <p><strong>Food for Thought: </strong>The TFSC Co-Directors are looking for feedback concerning our programming.
            We gave you food, you give us thoughts. (See, there really is no such thing as a free lunch!)</p>
          <form id="form" name="form" method= "POST" action="nfevaluation.php?id=<?php echo $encode;?>">
            <?php
              //Connection string 
              $connection = mysql_connect("localhost","root", "");
              //Run the connection string to connecct to the databse
              mysql_select_db("tfscdb", $connection) or die("Cannot open the database");
              //set variable query for a query statement
              $query = "select description, id, question_flag, number_of_choices from question where event_type = 'FACULTY' order by `order`;";  
              //execute the query           
              $result = mysql_query($query, $connection) or die ("Could not execute sql: $query");
              // POST result record
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
                       if (!isset($_POST[$row['id']]))  
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
                      echo "<div><label class='radio'><input type = 'radio' name = '$row[id]' value = '1'";
                      if ($_POST[$row['id']] == '1') 
                        echo "checked";
                      echo "> Yes </label>";
                      echo "<label class='radio'><input type = 'radio' name = '$row[id]' value = '2'";
                      if ($_POST[$row['id']] == '2') 
                        echo "checked";
                      echo "> No </label></div>";
                    }                  
                    else
                    {
                      echo "<div>";
                      for ($j=0; $j < $row['number_of_choices']; $j++) 
                      { 
                        $rate = $j+1;
                        echo "<label class='radio'><input type = 'radio' name ='$row[id]' value = '$rate'";
                        if ($_POST[$row['id']] == $rate) 
                          echo "checked";
                        echo ">".$rate."</label>";
                      }
                      echo "</div>";
                    }               
                  } 
                  else if ($row['question_flag'] == 'C') 
                  {
                    echo "<textarea class = 'span11' name ='$row[id]' placeholder = 'Comments here...'></textarea>";                 
                  }              
              }
              //insert data into database
              if (isset($_POST['submit'])) {
                if ($check == true){
                  //execute the query           
                  $result = mysql_query($query, $connection) or die ("Could not execute sql: $query");
                  // get result record
                  $num_rows = mysql_num_rows($result);
                  //insert each line of answer
                  for ($j=0; $j<$num_rows ; $j++) { 
                    $row = mysql_fetch_array($result);                  
                    $answer = $_POST[$row['id']];
                    if ($row['question_flag'] == 'R'){
                      $sql = "insert into evaluation (`id`, `question_id`, `event_id`, `session_id`, `user_rating`, `user_comment`) values(null, $row[id], $id, null, $answer, null);";
                      $insert = mysql_query($sql, $connection) or die ("Could not excute sql $sql"); 
                    }else if ($row['question_flag'] == 'C') {
                      if ($answer != null) {
                        $sql = "insert into evaluation (`id`, `question_id`, `event_id`, `session_id`, `user_rating`, `user_comment`) values(null, $row[id], $id, null, null, '$answer');";
                        $insert = mysql_query($sql, $connection) or die ("Could not excute sql $sql"); 
                      }                  
                    } 
                                       
                  }
                  //header("Location: thanks.php");
                  echo "<script>location.href='thanks.php';</script>";
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