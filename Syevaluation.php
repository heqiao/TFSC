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
  <div class="row-fluid">
    <div class="span7 offset2">
 <?php
      $encode = $_GET['id'];
                      
      $urlenc = new Encryption();           
      $id = $urlenc->decode("$encode");
      //Connection string 
      $connection = mysql_connect("localhost","root", "");
      //Run the connection string to connecct to the databse
      mysql_select_db("tfscdb", $connection) or die("Cannot open the database");
      //Query to pull data for different sessions and speakers
      $query = "SELECT `date`, first_name, session.title, group_name, session.id,name
                FROM speaker, session_speaker, session , event
                WHERE (speaker.id = session_speaker.speaker_id
                AND session_speaker.session_id = session.id
                AND session.event_id = event.id)
                and event.id=$id
                ORDER BY `order`;";

            //Connection string 
            $connection = mysql_connect("localhost","root", "");
            //Run the connection string to connecct to the databse
            mysql_select_db("tfscdb", $connection) or die("Cannot open the database"); 

            //execute the query  $result= used for date only; $result1 = used for rest of code         
            $result = mysql_query($query, $connection) or die ("Could not execute sql: $query");
            $result1 = mysql_query($query, $connection) or die ("Could not execute sql: $query");
            
            // get result record
            $num_rows = mysql_num_rows($result1);

            //Get result to get date
            $row = mysql_fetch_array($result);

            //Display event information
            echo "<h3><center>$row[name] Survey</center></h3>";
            echo "<h4><center>".date("l, F d, Y",strtotime($row['0']))."<center></h4>";      
  ?>
        <p>The TFSC Co-Directors are looking for feedback concerning our programming. Please complete
         this evaluation form so we can better serve your teaching needs in the future. We hope you enjoyed the morning!</p>
         
        <p>On a scale of 1 to 5, with 1 being Very unsatisfied and 5 being Very satisfied, please 
          indicate your overall level of satisfaction with the sessions you attended today.</p>
        <!-- Form to post data-->
        <form id="form" name="form" method= "POST" action="syevaluation.php?id=<?php echo $encode;?>">
  <?php
          //Set groupname to nothing, used to check for duplicates because of speakers
          $groupName= "";

          //Variable to check if all required fields are filled, when false will show reminder to answer
          $check = true;
            
          //For loop to loop through the session records from query
          for($i=1;$i<=$num_rows;$i++)
            { 
                $row1 = mysql_fetch_array($result1);

                //If group name is empty then use this code
                if ($row1['group_name'] == null) 
                {                 
                    //Retrieve the description of the session
                    echo "<p><strong>".$row1['2'].","."</strong>";
                    echo "   ";
                    
                    echo "<strong>"."with "."</strong>";

                    //Retrieve the speaker's first name
                    echo "<strong>".$row1['first_name']." "."</strong>";

                    echo "</p>";
                    //Query to retrieve questions from database 
                    $Query = "select q.id, q.description, question_flag, number_of_choices, s.id
                    FROM question q
                    JOIN event e on e.event_type = q.event_type
                    join session s on s.event_id = e.id 
                    WHERE q.event_type = 'Symposium'
                    AND `group` = 'session'
                    and s.id = ".$row1[4]."
                    ORDER BY s.id;";
                    
                    //Call function to display questions under session
                    Display($Query);
                }

                //If the group name is not null, then it is session has subsessions (it is a breakout session)
                else
                { 
                  //Display the group name only once
                  if ($row1['group_name'] != $groupName) 
                  {

                    $groupName = $row1['group_name'];
                    //Retrieve the group name that has subsessions
                    echo "<p><strong>".$row1['group_name'].": </strong></p>";
                    
                    $selectName = str_replace(" ", "", $groupName);

                    echo "<select class = 'span12' name = '$selectName'>";

                    echo "<option value = '0'>Choose session</option>";
                    
                    //Query to get the sessions that belong with the group
                    $subsessionQuery = "select s.id, s.title, first_name from session s join session_speaker ss on s.id = ss.session_id
                                        join speaker sp on sp.id = ss.speaker_id where group_name ='".$groupName."' and s.event_id = $id order by `order`;";

                    //Run query
                    $list = mysql_query($subsessionQuery, $connection) or die ("Could not execute sql: $query");  
                   
                   //Retrieve # of rows from query
                    $numRows = mysql_num_rows($list);

                   //Create variable to check for sessions that have multiple speakers 
                    $currentSession ="";
                    
                   //Loop through the sessions that belong within the group 
                   for ($j=0; $j < $numRows; $j++) 
                   { 
                      //Get results from query
                      $rowList = mysql_fetch_array($list);

                      //If the current session has not already been displayed, then display in drop down list
                      if ($rowList['0'] != $currentSession)
                      { 
                        $sessionIDnum = $rowList['0'];
                        echo "<option value= '$sessionIDnum' ";

                          if ($_POST[$selectName] == $sessionIDnum) 
                             echo "selected='selected'";
                          
                        echo ">".$rowList['1'];

                        //Set variable to current session id
                        $currentSession = $rowList['0'];
                      }

                        echo " with ";

                      //Retrieve the speaker's first name
                      echo $rowList['first_name']." "; 

                     echo "</option>";
                      
                   }

                    echo "</select>";

                    //Validation for Session drop down list
                    if (isset($_POST['submit'])) 
                    {     
                      if ($_POST[$selectName] == 0) 
                      {
                        echo "<div class='alert alert-error'>Please select the session you attended.</div>";
                        global $check;
                        $check = false;
                      }           
                    }

                    $Query = "select q.id, q.description, question_flag, number_of_choices, s.id
                    FROM question q
                    JOIN event e on e.event_type = q.event_type
                    join session s on s.event_id = e.id 
                    WHERE q.event_type = 'Symposium'
                    AND `group` = 'session'
                    and s.id = ".$row1[4]."
                    ORDER BY s.id;";

                    Display($Query);
                  }
                }                  
              
            }

            $Query1="select * from question where `group` = 'generic' and event_type ='Symposium'";

            DisplayGeneric($Query1);
          
            function Display($query)
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
                  echo "<p>";
                  echo $i + 1;
                  echo ". ";
                  echo $row['1'];
                  echo "</p>";
                  
                   if (isset($_POST['submit']) && $row['2'] != 'C') 
                    {    
                      if (!isset($_POST[$row[0].$row[4]]))   
                      {
                        echo "<div class='alert alert-error'>Please answer this question.</div>";
                        global $check;
                        $check = false;
                      }
                    }

                  //determine question format according to question flag
                  if($row['2'] == 'R')
                  { 
                    if ($row['3'] == 2) 
                    { 
                      echo "<label class='radio'><input type = 'radio' name ='$row[0].$row[4]' value = '1'";
                      if ($_POST[$row[0]] == '1') 
                        echo "checked";
                      echo "> Yes </label>";
                      echo "<label class='radio'><input type = 'radio' name ='$row[0].$row[4]' value = '2'";
                      if ($_POST[$row[0]] == '2') 
                        echo "checked";
                      echo "> No </label>";  
                     
                    }                  
                    else
                    {//pulls number of choices (column 3)
                      for ($j=0; $j < $row['3']; $j++) 
                      { //echo "<td>".$row[0].$row[4]."</td>";
                        $rate = $j + 1;
                        echo "<label class='radio'><input type = 'radio' name ='$row[0]$row[4]' value = '$rate'";
                        if ($_POST[$row[0].$row[4]] == $rate) 
                          echo "checked";
                        echo ">".$rate."</label>";
                      }
                    }           
                  } 
                  else if ($row['2'] == 'C') 
                  {
                    echo "<textarea class='span12' name ='$row[0]$row[4]' placeholder = 'Comments here...'>";
                     if(isset($_POST[$row[0].$row[4]]))
                        {
                           echo $_POST[$row[0].$row[4]];
                        }
                    echo "</textarea>";          
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
                    echo "<p><strong>".$row['1']."</strong></p>";
                                    
                    //determine question format according to question flag
                    if($row['3'] == 'R')
                    {
                      if ($row['6'] == 2) 
                      {
                        echo "<label class='radio'><input type = 'radio' name = '$row[0]' value = '1' ";
                        if ($_POST[$row['0']] == '1') 
                          echo "checked";
                        echo "> Yes </label>";
                        echo "<label class='radio'><input type = 'radio' name = '$row[0]' value = '2' ";
                        if ($_POST[$row['0']] == '2') 
                          echo "checked";
                        echo "> No </label>";
                      }                  
                      else
                      {
                        for ($j=0; $j < $row['6']; $j++) 
                        { 
                          $rate = $j + 1;
                          echo $rate;
                          echo "<label class='radio'><input type = 'radio' name ='$row[0]' value = '$rate' ";
                          if ($_POST[$row['0']] == $rate) 
                            echo "checked";
                          echo ">".$rate."</label>";
                        }
                      }              
                    } 
                    else if ($row['3'] == 'C') 
                    {
                      echo "<textarea class='span12' name ='$row[0]' placeholder = 'Comments here...'>";
                      if(isset($_POST[$row[0]]))
                        {
                           echo $_POST[$row[0]];
                        }
                      echo "</textarea>";             
                    }       
                }
            }

        //When user clicks the submit button...
        if (isset($_POST['submit'])) 
        {
          
         if ($check == true)
         { 
            $query5 = "SELECT *
                        FROM Question
                        WHERE event_type = 'SYMPOSIUM'
                        ORDER BY `GROUP`";
            //execute the query           
            $result = mysql_query($query5, $connection) or die ("Could not execute sql: $query5");
          
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
                     $sql = "insert into evaluation(`id`, `question_id`, `event_id`, `session_id`, `user_rating`, `user_comment`) values(null,$row[0],1,$sessionid,$rating,NULL);";
                    }else  
                    { 
                       $answer = $_POST[$row['0']]; 

                       if ($answer != null) 
                       {
                        $sql = "insert into evaluation (`id`, `question_id`, `event_id`, `session_id`, `user_rating`, `user_comment`) values(null, $row[0], 1, NULL, NULL, '$answer');";
                       }                      
                    }

                    //Insert data from form into evaluation table 
                    $insert = mysql_query($sql, $connection) or die ("Could not execute sql: $sql"); 
                  }
                 //Insert statements for session question types
                 else
                 {
                       $query = "SELECT DISTINCT group_name
                                  FROM SESSION S
                                  WHERE event_id =$id";
                      
                        $resultSession = mysql_query($query, $connection) or die ("Could not execute sql: $query");
                        $numSession = mysql_num_rows($resultSession);
                         
                         for ($s=0; $s<$numSession; $s++)
                         {
                            $rowSess= mysql_fetch_array($resultSession);
                            $group = str_replace(" ", "", $rowSess['group_name']);

                            if ($group == null || $group == '') 
                            {
                              $getSessionQuery = "SELECT *
                                                  FROM SESSION S
                                                  WHERE event_id =$id
                                                  AND group_name = '' OR group_name IS NULL";

                              $resultSessionNull = mysql_query($getSessionQuery, $connection) or die ("Could not execute sql: $query");
                              $numSessionNull = mysql_num_rows($resultSessionNull);

                              for ($g=0; $g < $numSessionNull; $g++) 
                                { 
                                  $nullSession = mysql_fetch_array($resultSessionNull);  
                                  $sessionid = $nullSession['0'];
                                  $answer=$_POST[$row[0].$sessionid];

                                  if ($row['3'] == 'R')
                                  { 
                                   $sql = "insert into evaluation(`ID`, `question_id`, `event_id`, `session_id`, `user_rating`, `user_comment`) values(null,$row[0],$id,$sessionid,$answer,NULL);";
                                  }
                           
                                  else  
                                  {
                                     if ($answer != null) 
                                     {
                                      $sql = "insert into evaluation (`ID`, `question_id`, `event_id`, `session_id`, `user_rating`, `user_comment`) values(null, $row[0], $id, $sessionid, NULL, '$answer');";
                                     }
                                  }
                                  //Insert data from form into evaluation table 
                                  $insert = mysql_query($sql, $connection) or die ("Could not execute sql:$sql");  
                                }  
                             
                            }
                            else
                            { 
                              $querySession = "SELECT id
                                                FROM SESSION
                                                WHERE event_id =$id
                                                AND group_name = '".$rowSess['group_name']."'
                                                 limit 1";

                              $rSess = mysql_query($querySession, $connection) or die ("Could not execute sql: $querySession");
                              $numSess = mysql_num_rows($rSess);

                              for ($q=0; $q < $numSess ; $q++) 
                              { 
                                $getSess = mysql_fetch_array($rSess);
                                $sessionid = $_POST[$group];
                                echo $row[0].$sessionid;
                                $answer=$_POST[$row[0].$getSess['id']];

                                  if ($row['3'] == 'R')
                                  { 
                                   $sql = "insert into evaluation(`id`, `question_id`, `event_id`, `session_id`, `user_rating`, `user_comment`) values(null,$row[0],$id,$sessionid,$answer,NULL);";
                                   //echo $sql."<br></BR>";
                                  }
                           
                                  else  
                                  {
                                     if ($answer != null) 
                                     {
                                      $sql = "insert into evaluation (`id`, `question_id`, `event_id`, `session_id`, `user_rating`, `user_comment`) values(null, $row[0], $id, $sessionid, NULL, '$answer');";
                                     }
                                  }
                              }
                              
                            //Insert data from form into evaluation table 
                             $insert = mysql_query($sql, $connection) or die ("Could not execute sql:$sql");
                            }   
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