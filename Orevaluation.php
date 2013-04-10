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
    <!-- Form to post data-->
    <h3>New Faculty Orientation Survey</h3>
     <p>Please rate the following questions on a scale of 1 to 5, with 1 being “very unsatisfied” 
          and 5 being “very satisfied”.</p>
    <h4>New Faculty Orientation - Morning Sessions Evaluation</h4>
  <form id="form" name="form" method= "POST" action="<?php echo $_SERVER['PHP_SELF'];?>">
    <?php
      //Variable to check if all required fields are filled, 
      $check = true;

      //Query to pull back questions for Morning Session
      $query1="sELECT *
                FROM Question
                WHERE event_type = 'Orientation'
                AND question_flag = 'R'
                ORDER BY 'order';";
      
      //Query to pull back questions for Afternoon Session
      $query3 = "sELECT *
                  FROM Question
                  WHERE event_type = 'Orientation'
                  AND `order` <>1
                  AND question_flag = 'R'
                  ORDER BY 'order' ";

      //Query to pull back comment questions 
      $query4 = "sELECT *
                  FROM Question
                  WHERE event_type = 'Orientation'
                  AND question_flag = 'C'
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
                      for ($j=0; $j < $row['6']; $j++) 
                      { 
                        $rate = $j + 1;
                        echo "<label class='radio'><input type = 'radio' name ='$row[0]' value = '$rate'";
                       // if ($_POST[$row[1]] == $rate) 
                          //echo "checked";
                        echo ">".$rate."</label>";
                      }
                     }
                   if (isset($_POST['submit'])) 
                    {    
                    if (!isset($_POST[$row['0']]))
                    {
                      ?>
                         <div class="alert alert-error">
                             Please answer this question.
                         </div>
                         <?php
                      $check = false;
                    }                                  
                 }         
                 }
                 //Checks to see if it is a comment question
                  else
                    {
                      $textarea = $row['0'].$groupName;
                      echo "<textarea class = 'span12' name = '".$textarea."'></textarea>";  
                    }
               }

               //For session question
               else
               {  
                  //Display question
                  echo  "<p><strong>".$row['1'].":</strong></p>";
                  //Query to pull back sessions for the question
                  $query2="sELECT s.session_id, q.question_id, s.title, number_of_choices, question_flag, e.event_id
                            FROM SESSION s
                            JOIN event e ON s.event_id = e.event_id
                            JOIN question q ON q.event_type = e.event_type
                            WHERE q.event_type = 'orientation'
                            AND group_name = '".$groupName."' 
                             AND QUESTION_FLAG = 'R'
                            AND `GROUP` = 'SESSION'";
                   
                  //Execute the query         
                  $result2 = mysql_query($query2, $connection) or die ("Could not execute sql: $query2");
                  //Get number of rows from question
                  $num_rows1 = mysql_num_rows($result2);

                  //Loops through the question and session information
                  for($k=0; $k<$num_rows1; $k++)
                  {
                     $row1 = mysql_fetch_array($result2);
                     $session_array[]=$row1['0'];
                     echo "<p>".$row1['2']."</p>";
                      if (isset($_POST['submit'])) {    
                            if (!isset($_POST[$row1['0']])){
                              ?>
                               <div class="alert alert-error">
                                   Please answer this question.
                               </div>
                              <?php
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
                      echo "<textarea class = 'span12' name ='".$textarea."' rows='3' cols='63'></textarea>";              
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
                    echo "<textarea class = 'span12' name ='".$row[0]."'></textarea>";              
                  }       
              }
            
            }

       if (isset($_POST['submit'])) 
        {
          
         if ($check == true)
         {  
            $totalSql='';
            $query5 = "select *
                        FROM Question
                        WHERE event_type = 'Orientation' ORDER BY `ORDER`";
            //execute the query           
            $result = mysql_query($query5, $connection) or die ("Could not execute sql: ".$query5);
          
            // get result record
            $num_rows = mysql_num_rows($result);

            
            //insert each line of answer
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
                     $sql = "insert into evaluation(`Evaluation_ID`, `Question_ID`, `Event_ID`, `Session_ID`, `User_Rating`, `User_Comment`) values(null,$row[0],2,$sessionid,$rating,NULL);";
                    }
                 
                    else  
                    { 
                       $answer = $_POST[$row['0']]; 
                       if ($answer != null) 
                       {
                        $sql = "insert into evaluation (`Evaluation_ID`, `Question_ID`, `Event_ID`, `Session_ID`, `User_Rating`, `User_Comment`) values(null, $row[0], 2, NULL, NULL, '$answer');";
                       }
                       else
                       {
                        $sql = "insert into evaluation (`Evaluation_ID`, `Question_ID`, `Event_ID`, `Session_ID`, `User_Rating`, `User_Comment`) values(null, $row[0], 2, NULL, NULL, '');";                     
                       }
                      
                    }
                    //Insert data from form into evaluation table 
                   $insert = mysql_query($sql, $connection) or die ("Could not excute sql:".$sql);   
                  }
                  //Insert statements for session question types
                  else
                  { 
                    $comment=$_POST[$row['0']];
                    $query2 = "sELECT Q.question_id, S.session_id, e.event_id
                                  FROM QUESTION Q
                                  JOIN EVENT E ON E.EVENT_TYPE = Q.EVENT_TYPE
                                  JOIN SESSION S ON S.EVENT_ID = E.EVENT_ID
                                  WHERE E.EVENT_ID =2
                                  AND QUESTION_ID =36";
          
                       $resultSession = mysql_query($query2, $connection) or die ("Could not execute sql: $query2");
                       $numSession = mysql_num_rows($resultSession);

                       for ($s=0; $s<$numSession; $s++)
                       {
                          $rowSess= mysql_fetch_array($resultSession);
                          $sessionid = $rowSess['1'];
                          $rating=$_POST[$rowSess['1']];

                          if ($row['3'] == 'R')
                          {
                           $sql = "insert into evaluation(`Evaluation_ID`, `Question_ID`, `Event_ID`, `Session_ID`, `User_Rating`, `User_Comment`) values(null,$row[0],2,$sessionid,$rating,NULL);";
                          }
                       
                          else  
                          {
                             if ($answer != null) 
                             {
                              $sql = "insert into evaluation (`Evaluation_ID`, `Question_ID`, `Event_ID`, `Session_ID`, `User_Rating`, `User_Comment`) values(null, $row[0], 2, NULL, NULL, $comment);";
                             }
                             else
                             {
                              $sql = "insert into evaluation (`Evaluation_ID`, `Question_ID`, `Event_ID`, `Session_ID`, `User_Rating`, `User_Comment`) values(null, $row[0], 2, NULL, NULL, '');";                     
                             }
                          }
                          //Insert data from form into evaluation table 
                           $insert = mysql_query($sql, $connection) or die ("Could not excute sql:".$sql);   
                       }
                    }
                  }                
                }    
                header("Location: thanks.php");
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