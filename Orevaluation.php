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
    <div class = "span7 offset2">
      <?php
        $encode = $_GET['id'];
                      
        $urlenc = new Encryption();           
        $id = $urlenc->decode("$encode");
      ?>
    <!-- Form to post data-->
  <form id="form" name="form" method= "POST" action="orevaluation.php?id=<?php echo $encode;?>">
    <?php
    //Query to pull event information
      $query = "select * FROM `event` WHERE id =$id";

          //Get connection
            $connection = mysql_connect("localhost","root", "");
          //Run the connection string to connecct to the databse
            mysql_select_db("tfscdb", $connection) or die("Cannot open the database"); 
            //execute the query  $result= used for date only; $result1 = used for rest of code         
            $result = mysql_query($query, $connection) or die ("Could not execute sql: $query");

            //Get result to get date
            $row = mysql_fetch_array($result);

            echo "<center><h3>$row[name] Survey</h3></center>";
            echo "<p>Please rate the following questions on a scale of 1 to 5, with 1 being “very unsatisfied” 
                      and 5 being “very satisfied”.</p>";
            echo "<h4>New Faculty Orientation - Morning Sessions Evaluation</h4>";
      //Variable to check if all required fields are filled, 
      $check = "true";

      //Query to pull back questions for Morning Session
      $query1= "select *
                FROM question q join event e 
                on e.event_type = q.event_type
                WHERE e.event_type = 'Orientation'
                AND question_flag = 'R'
                and e.id = $id 
                ORDER BY 'order';";
      
      //Query to pull back questions for Afternoon Session
      $query3 = "select *
                  FROM question q join event e 
                  on e.event_type = q.event_type 
                  WHERE e.event_type = 'Orientation'
                  AND `order` <>1
                  AND question_flag = 'R'
                  and e.id = $id 
                  ORDER BY 'order' ";

      //Query to pull back comment questions 
      $query4 = "select *
                  FROM question q join event e 
                  on e.event_type = q.event_type
                  WHERE e.event_type = 'Orientation'
                  AND question_flag = 'C'
                  and e.id = $id 
                  ORDER BY 'order' ";     
     
      //Call function to pull back questions within the morning session
      DisplayQues($query1, "Morning Session");
    

      echo "<h4>New Faculty Orientation - Afternoon Sessions Evaluation</h4>";
      
      //Call function to pull back questions within the afternoon session
      DisplayQues($query3,"Afternoon Session");   
      
      //Call function to pull back comment questions
      DisplayGeneric($query4); 

      //Function to display questions 
      function DisplayQues($query, $groupName)
      { 
        global $id;
          //Connection string 
          $connection = mysql_connect("localhost","root", "");
          //Run the connection string to connecct to the databse
          mysql_select_db("tfscdb", $connection) or die("Cannot open the database"); 

          //execute the query           
          $result = mysql_query($query, $connection) or die ("Could not execute sql: $query");
          // get result record
          $num_rows = mysql_num_rows($result);

          for($i=0;$i<$num_rows;$i++)
          {
               $row = mysql_fetch_array($result);              
                
               if($row['5']== 'GENERIC')
               {  
                  echo "<p>".$row['1']."</p>"; 
                 
                 //Checks to see if qustions use radio buttons
                 if($row['3'] == 'R')
                 { 
                     if ($row['6'] == 2) 
                     {
                        echo "<label class='radio'><input type = 'radio' name = '$row[id]' value = '1'";
                        if ($_POST[$row['question_id']] == '1') 
                          echo "checked";
                        echo "> Yes </label>";
                        echo "<label class='radio'><input type = 'radio' name = '$row[id]' value = '2'";
                        if ($_POST[$row['question_id']] == '2') 
                          echo "checked";
                        echo "> No </label>";
                     }                  
                     else
                     {//pulls number of choices (column 6)
                      for ($j=0; $j < $row['6']; $j++) 
                      { 
                        $rate = $j + 1;
                        echo "<label class='radio'><input type = 'radio' name ='$row[0]' value = '$rate'";
                       if ($_POST[$row[0]] == $rate) 
                       {
                        echo "checked";
                       }
                          
                        echo ">".$rate."</label>";
                      }
                     }
                   if (isset($_POST['submit'])) 
                    {    
                      if (!isset($_POST[$row['0']]))
                      {
                        echo "<div class='alert alert-error'>Please answer this question.</div>";
                        global $check;
                        $check = false;
                      }
                                                       
                    }

                 }
                 //Checks to see if it is a comment question
                  else
                    {
                      $textarea = $row['0'].$groupName;
                      echo "<textarea class = 'span10' name = '".$textarea."'>";
                      if(isset($_POST[$textarea]))
                        {
                           echo $_POST[$textarea];
                        }
                      echo "</textarea>";  
                    }

               }

               //For session question
               else
               {  
                  //Query to pull back sessions for the question
                  $query2="select s.id, q.id, s.title, number_of_choices, question_flag, e.id
                            FROM SESSION s
                            JOIN event e ON s.event_id = e.id
                            JOIN question q ON q.event_type = e.event_type
                            WHERE q.event_type = 'orientation'
                            AND group_name = '".$groupName."' 
                            AND question_flag = 'R'
                            AND `group` = 'SESSION' and e.id = $id";
                   
                  //Execute the query         
                  $result2 = mysql_query($query2, $connection) or die ("Could not execute sql: $query2");
                  //Get number of rows from question
                  $num_rows1 = mysql_num_rows($result2);

                  if ($num_rows1 != 0)
                  {
                    //Display question
                    echo  "<p><strong>".$row['1'].":</strong></p>";
                  }
                  //Loops through the question and session information
                  for($k=0; $k<$num_rows1; $k++)
                  {
                     $row1 = mysql_fetch_array($result2);
                     
                     echo "<p>".$row1['2']."</p>";
                      if (isset($_POST['submit'])) {    
                            if (!isset($_POST[$row1['0']])){
                              echo "<div class='alert alert-error'>Please answer this question.</div>";
                              global $check;
                              $check = false;
                            } 
                      }
                    
                    if($row1['4'] == 'R')
                    { 

                      if ($row1['3'] == 2) 
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
                      {//pulls number of choices (column 6)
                         for ($j=0; $j < $row1['3']; $j++) 
                          { 
                            $session = $row1[0];
                            $rate = $j+1;
                            echo "<label class='radio'><input type = 'radio' name ='$session' value = '$rate'";
                            if ($_POST[$row1['0']] == $rate) 
                               echo "checked";
                            echo ">".$rate."</label>";
                          }                                
                      }
                        
                      }        
                    else if ($row1['4'] == 'C') 
                    {
                      $textarea = $row['0'].$groupName;
                      echo "<textarea class = 'span10' name ='".$textarea."'>";
                      if(isset($_POST[$textarea]))
                        {
                           echo $_POST[$textarea];
                        }
                      echo "</textarea>";              
                    }
                  }          
               }
      
          }
          
      }

            function DisplayGeneric($query)
            {           
            //Connection string 
              $connection = mysql_connect("localhost","root", "");
              //Run the connection string to connecct to the databse
              mysql_select_db("tfscdb", $connection) or die("Cannot open the database");
              //execute the query           
              $result = mysql_query($query, $connection) or die ("Could not execute sql: $query");
              // get result record
              $num_rows = mysql_num_rows($result);

              //read questions from database
              for($i=0;$i<$num_rows;$i++)
              {
                  $row = mysql_fetch_array($result);
                  echo "<p>".$row['1']."</p>";
                                  
                  //determine question format according to question flag
                  if($row['3'] == 'R')
                  {
                    if ($row['6'] == 2) 
                    {
                      echo "<label class='radio'><input type = 'radio' name = '$row[0]' value = '1'";
                      if ($_POST[$row['0']] == '1') 
                        echo "checked";
                      echo "> Yes </label>";
                      echo "<label class='radio'><input type = 'radio' name = '$row[0]' value = '2'";
                      if ($_POST[$row['0']] == '2') 
                        echo "checked";
                      echo "> No </label>";
                    }                  
                    else
                    {
                      for ($j=0; $j < $row['6']; $j++) 
                      { 
                        echo $j + 1;
                        $rate = $i+1;
                        echo "<label class='radio'><input type = 'radio' name ='".$row[0]."' value = '$rate'";
                        if ($_POST[$row['0']] == $rate) 
                          echo "checked";
                        echo "></label>";
                      }
                    }             
                  } 
                  else if ($row['3'] == 'C') 
                  {
                    echo "<textarea class = 'span10' name ='".$row[0]."'>";
                    if(isset($_POST[$row[0]]))
                        {
                           echo $_POST[$row[0]];
                        }
                    echo "</textarea>";              
                  }       
              }            
            }

       if (isset($_POST['submit'])) 
        {
         if ($check == true)
         {  
            //Connection string 
            $connection = mysql_connect("localhost","root", "");
            //Run the connection string to connecct to the databse
            mysql_select_db("tfscdb", $connection) or die("Cannot open the database"); 

            $query5 = "select * FROM question WHERE event_type = 'ORIENTATION' ORDER BY `order`;";
            //execute the query           
            $result = mysql_query($query5, $connection) or die ("Could not execute sql: ".$query5);
          
            // get result record
            $num_rows = mysql_num_rows($result);
            
            for ($j=0; $j<$num_rows ; $j++) 
            { 
                  $row = mysql_fetch_array($result);
                  
                  //Insert statements for generic questions
                  if ($row['5']== 'GENERIC')
                  { 
                    $rating= $_POST[$row['0']];
                    $sessionid = 'null';

                    if ($row['3'] == 'R')
                    {
                     $sql = "insert into evaluation(`id`, `question_id`, `event_id`, `session_id`, `user_rating`, `user_comment`) values(null,$row[0],$id,$sessionid,$rating,NULL);";
                    }
                 
                    else  
                    { 
                       $answer = $_POST[$row['0']]; 
                       if ($answer != null) 
                       {
                        $sql = "insert into evaluation (`id`, `question_id`, `event_id`, `session_id`, `user_rating`, `user_comment`) values(null, $row[0], $id, NULL, NULL, '$answer');";
                       }
                       else
                       {
                        $sql = "insert into evaluation (`id`, `question_id`, `event_id`, `session_id`, `user_rating`, `user_comment`) values(null, $row[0], $id, NULL, NULL, '');";                     
                       }
                      
                    }
                    //Insert data from form into evaluation table 
                   $insert = mysql_query($sql, $connection) or die ("Could not excute sql:".$sql);   
                  }
                  //Insert statements for session question types
                  else
                  { 
                    $comment=$_POST[$row['0']];
                    $query2 = "select Q.id, S.id, e.id
                                  FROM question Q
                                  JOIN event E ON E.event_type = Q.event_type
                                  JOIN session S ON S.event_id = E.id
                                  WHERE E.id =$id
                                  AND q.id =36";
          
                       $resultSession = mysql_query($query2, $connection) or die ("Could not execute sql: $query2");
                       $numSession = mysql_num_rows($resultSession);

                       for ($s=0; $s<$numSession; $s++)
                       {
                          $rowSess= mysql_fetch_array($resultSession);
                          $sessionid = $rowSess['1'];
                          $rating=$_POST[$rowSess['1']];

                          if ($row['3'] == 'R')
                          {
                           $sql = "insert into evaluation(`id`, `question_id`, `event_id`, `session_id`, `user_rating`, `user_comment`) values(null,$row[0],$id,$sessionid,$rating,NULL);";
                          }
                       
                          else  
                          {
                             if ($answer != null) 
                             {
                              $sql = "insert into evaluation (`id`, `question_id`, `event_id`, `session_id`, `user_rating`, `user_comment`) values(null, $row[0], $id, NULL, NULL, $comment);";
                             }
                             else
                             {
                              $sql = "insert into evaluation (`id`, `question_id`, `event_id`, `session_id`, `user_rating`, `user_comment`) values(null, $row[0], $id, NULL, NULL, '');";                     
                             }
                          }
                          //Insert data from form into evaluation table 
                           $insert = mysql_query($sql, $connection) or die ("Could not excute sql:".$sql);   
                       }
                    }
            } 
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