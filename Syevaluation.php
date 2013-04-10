<?php include("header.php");?>
<!doctype html>
<html lang="en">
<head></head>
<body>
<div class="container">
  <div class="row">
    <div class="threecol">
      <!--  Contact Information -->
      <address>
      <p><img border="0" alt=" "  src="http://tfsc.uark.edu/WCTFSC_color_version.png" /> </p>
      <p>Harmon Avenue Parking Facility<br />
      146 N. Harmon Avenue<br />
      HAPF-703<br />
      Fayetteville, AR 72701</p>
      <p>Lori L. Libbert<br />
      Special Events Manager</p>
      <p>P: 479-575-3222<br />
      F: 479-575-7086<br />
      <a  href="mailto:tfsc@uark.edu">tfsc@uark.edu</a></p>
      </address>
    </div>
    <!-- Form to post data-->
    <div class="sixcol centerPlate">
    <h3><center>Winter Teaching Symposium Survey</center></h3>
 <?php
      //Query to pull data for different sessions and speakers
      $query = "SELECT `DATE` , SPEAKER.TITLE, PREFIX, FIRST_NAME, LAST_NAME, DEPARTMENT, SESSION.TITLE, ORGANIZATION,GROUP_NAME, SESSION.session_id
                FROM SPEAKER, SESSION_SPEAKER, SESSION , EVENT
                WHERE (SPEAKER.SPEAKER_ID = SESSION_SPEAKER.SPEAKER_ID
                AND SESSION_SPEAKER.SESSION_ID = SESSION.SESSION_ID
                AND SESSION.EVENT_ID = EVENT.EVENT_ID)
                ORDER BY `ORDER`;";

            //execute the query  $result= used for date only; $result1 = used for rest of code         
            $result = mysql_query($query, $connection) or die ("Could not execute sql: $query");
            $result1 = mysql_query($query, $connection) or die ("Could not execute sql: $query");
            
            // get result record
            $num_rows = mysql_num_rows($result1);

            //Get result to get date
            $row = mysql_fetch_array($result);

            //Display date
            echo "<h4><center>".date("l, F d, Y",strtotime($row['0']))."<center></h4>";      
  ?>
        <p>The TFSC Co-Directors are looking for feedback concerning our programming. Please complete
         this evaluation form so we can better serve your teaching needs in the future. We hope you enjoyed the morning!</p>
         
        <p>On a scale of 1 to 5, with 1 being Very unsatisfied and 5 being Very satisfied, please 
          indicate your overall level of satisfaction with the sessions you attended today.</p>

        <form id="form" name="form" method= "POST" action="<?php echo $_SERVER['PHP_SELF'];?>">
          <table align="center" witdh="100%">  

          <?php

            //Set groupname to nothing, used to check for duplicates because of speakers
             $groupName= "";
            
          //For loop to loop through the session records from query
          for($i=1;$i<=$num_rows;$i++)
            { 
                echo "<tr><td colspan = '5'>";
                $row1 = mysql_fetch_array($result1);

                //If group name is empty then use this code
                if ($row1['GROUP_NAME'] == null) 
                {                 
                    //Retrieve the description of the session
                    echo "<strong>".$row1['6'].","."</strong>";
                    echo "   ";
                    
                    if ($row1['2'] != null) {
                      //Retrieve the prefix of speaker
                      echo "<strong>"."with ".$row1['2']."</strong>";
                      echo "   ";
                    }else
                    {
                      echo "<strong>"."with "."</strong>";
                    }

                    //Retrieve the speaker's first name
                    echo "<strong>".$row1['3']." "."</strong>"; 
                    //Retrieve the speaker's last name
                    echo "<strong>".$row1['4']."</strong>";

                    if ($row1['1'] != null) {
                      //Retrieve the title of speaker
                      echo "<strong>, ".$row1['1']."</strong>";
                    }

                    if ($row1['5'] != null) {
                      //Retrieve the department of speaker
                      echo "<strong>, ".$row1['5']."</strong>";
                    }

                    if ($row1['7'] != null) {
                    //Retrieve the organization affliated with the speaker
                    echo "<strong>, ".$row1['7']."</strong>";
                    }

                    echo "</td></tr>";
                    echo "</tr><tr><td height = '7px'></td></tr>";
                    
                    //Query to retrieve questions from database 
                    $Query = "select q.question_id, q.description, question_flag, number_of_choices, s.SESSION_ID
                    FROM Question q
                    JOIN event e on e.event_type = q.event_type
                    join session s on s.event_id = e.event_id 
                    WHERE q.event_type = 'Symposium'
                    AND `Group` = 'session'
                    and s.SESSION_ID = ".$row1[9]."
                    ORDER BY s.SESSION_ID;";
                    
                    //Call function to display questions under session
                    Display($Query);
                }

                //If the group name is not null, then it is session has subsessions (it is a breakout session)
                else
                { 
                  //Display the group name only once
                  if ($row1['GROUP_NAME'] != $groupName) 
                  {
                    $groupName = $row1['GROUP_NAME'];
                  
                    //Retrieve the group name that has subsessions
                    echo "<strong>".$row1['GROUP_NAME'].": </strong>";
                    //echo $selected !== null?; 
                    echo "<select name = '$groupName'>";

                    echo "<option value ='0'>Choose session</option>";
                    
                    //Query to get the sessions that belong with the group
                    $subsessionQuery = "select s.SESSION_ID, s.TITLE, prefix, FIRST_NAME,LAST_NAME from session s join SESSION_SPEAKER ss on s.session_ID = ss.session_ID
                                        join speaker sp on sp.speaker_ID = ss.speaker_ID where GROUP_NAME ='".$groupName."' order by `order`;";

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
                      { $sessionIDnum = $rowList['0'];
                        //echo "<option><h1>".$sessionIDnum."</h1></option>";
                        echo "<option value= '$sessionIDnum' ";
                        
                         if ($_POST[$groupName] == $sessionIDnum) 
                              echo "selected='selected'";
                        echo ">".$rowList['1'];

                        //Set variable to current session id
                        $currentSession = $rowList['0'];
                      }


                      if ($rowList['2'] != null) 
                      {
                        //Retrieve the prefix of speaker
                        echo " with ".$row1['2'];
                        echo "   ";
                      }
                      else
                      {
                        echo " with ";
                      }

                      //Retrieve the speaker's first name
                      echo $rowList['3']; 
                      //Retrieve the speaker's last name
                      echo $rowList['4'];

                      echo "</option>";
                      
                   }

                    echo "</select>";

                    // if ($_POST[$groupName] == $rowList['0']) 
                    //   echo "selected";

                    // if (isset($_POST['submit'])) 
                    // {     
                    //   if ($_POST[$groupName] == 0)            
                    //   echo "<strong style='color: red;'>Please select a session.</strong>";
                    // }

                    echo "</td></tr>";

                    echo "</tr><tr><td height = '7px'></td></tr>";

                    $Query = "select q.question_id, q.description, question_flag, number_of_choices, s.SESSION_ID
                    FROM Question q
                    JOIN event e on e.event_type = q.event_type
                    join session s on s.event_id = e.event_id 
                    WHERE q.event_type = 'Symposium'
                    AND `Group` = 'session'
                    and s.SESSION_ID = ".$row1[9]."
                    ORDER BY s.SESSION_ID;";

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
                echo "<tr><td colspan = '6'>";
                $row = mysql_fetch_array($result);
                echo $i + 1;
                echo ". ";
                echo $row['1'];
                
                 if (isset($_POST['submit'])) 
                  {    
                    if (!isset($_POST[$row[0].$row[4]]) && $row['2'] == 'R')   
                                     
                    echo "<br><strong style='color: red;'>Please answer this question.</strong>";
                  }
                  

                echo "</td></tr><tr><td height = '7px'></td></tr><tr>";

                //determine question format according to question flag
                if($row['2'] == 'R')
                { 
                  if ($row['3'] == 2) 
                  { 
                    echo "<td width='120px'><label class='radio'><input type = 'radio' name ='$row[0].$row[4]' value = '1'";
                    if ($_POST[$row['question_id']] == '1') 
                      echo "checked";
                    echo "> Yes </label></td>";
                    echo "<td width='120px'><label class='radio'><input type = 'radio' name ='$row[0].$row[4]' value = '2'";
                    if ($_POST[$row['question_id']] == '2') 
                      echo "checked";
                    echo "> No </label></td>";  
                   
                  }                  
                  else
                  {//pulls number of choices (column 3)
                    for ($j=0; $j < $row['3']; $j++) 
                    { //echo "<td>".$row[0].$row[4]."</td>";
                      echo "<td width='120px'>";
                      $rate = $j + 1;
                      echo "<label class='radio'><input type = 'radio' name ='".$row[0].$row[4]."' value = '".$rate."'";
                      if ($_POST[$row[0].$row[4]] == $rate) 
                        echo "checked";
                      echo ">".$rate."</label>";
                      echo "</td>";
                      //echo  $row[question_id].$row[session_id];
                    }

                  } 
                  echo "</tr>";            
                } 
                else if ($row['2'] == 'C') 
                {
                  echo "<td colspan ='6'><textarea name ='text1'.$i+1 rows='3' cols='63'></textarea></td></tr>";              
                }
                
                echo "<tr><td height = '20px'></td></tr>";          
            }
            //Close the connection to the database   
            mysql_close();
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
                  echo "<tr><td colspan = '6'>";
                  $row = mysql_fetch_array($result);
                  echo "<strong>".$row['1']."</strong>";
                  echo "</td></tr><tr><td height = '7px'></td></tr><tr></strong>";
                                  
                  //determine question format according to question flag
                  if($row['3'] == 'R')
                  {
                    if ($row['6'] == 2) 
                    {
                      echo "<td width='120px'>Yes <input type = 'radio' name ='haha' value = '$i + 1'></td>";
                      echo "<td width='120px'>No <input type = 'radio' name ='haha' value = '$i + 1'></td>";
                    }                  
                    else
                    {
                      for ($j=0; $j < $row['6']; $j++) 
                      { 
                        echo "<td width='120px'>";
                        echo $j + 1;
                        echo "<input type = 'radio' name ='$i + 1' value = '$i + 1'>";
                        echo "</td>";
                      }
                    } 
                    echo "</tr>";            
                  } 
                  else if ($row['3'] == 'C') 
                  {
                    echo "<td colspan ='6'><textarea name ='text1'.$i+1 rows='3' cols='63'></textarea></td></tr>";              
                  }
                  
                  echo "<tr><td height = '20px'></td></tr>";          
            }
            //Close the connection to the database   
            mysql_close();
            }
          ?>
        <tr>
        <td colspan ="6" align="center"><input type ="submit" name = "submit" value = "Submit" style="height:30px;width:80px;font-size:15px;"/> </td>
        </tr>
          </table>
        </form> 
    </div>    
  </div>
</div>

</body>
</html>