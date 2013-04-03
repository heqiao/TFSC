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
        <h1>New Faculty Luncheon Survey</h1>
        <p><strong>Food for Thought: </strong>The TFSC Co-Directors are looking for feedback concerning our programming.
          We gave you food, you give us thoughts. (See, there really is no such thing as a free lunch!)</p>
        <form>
          <table align="center" witdh="100%">
          <?php
            //set variable query for a query statement
            $query = "select description, question_flag, number_of_choice from question where event_type = 'FACULTY' order by `order`;";  
            //execute the query           
            $result = mysql_query($query, $connection) or die ("Could not execute sql: $query");
            // get result record
            $num_rows = mysql_num_rows($result);

            //read questions from database
            for($i=0;$i<$num_rows;$i++)
            {
                echo "<tr><td colspan = '5'>";
                $row = mysql_fetch_array($result);
                echo $i + 1;
                echo ". ";
                echo $row['description'];
                echo "</td></tr><tr><td height = '7px'></td></tr><tr>";
                
                //determine question format according to question flag
                if($row['question_flag'] == 'R')
                {
                  if ($row['number_of_choice'] == 2) 
                  {
                    echo "<td width='120px'>Yes <input type = 'radio' name ='$i + 1' value = ''></td>";
                    echo "<td width='120px'>No <input type = 'radio' name ='$i + 1' value = ''></td>";
                  }                  
                  else
                  {
                    for ($j=0; $j < $row['number_of_choice']; $j++) 
                    { 
                      echo "<td width='120px'>";
                      echo $j + 1;
                      echo "<input type = 'radio' name ='$i + 1' value = ''>";
                      echo "</td>";
                    }
                  } 
                  echo "</tr>";                
                } 
                else if ($row['question_flag'] == 'C') 
                {
                  echo "<td colspan ='5'><textarea rows='3' cols='63'></textarea></td></tr>";                
                }               
                echo "<tr><td height = '20px'></td></tr>";          
            }
          ?>
              <tr>
                <td height = "40px"></td>
              </tr>
              <tr>
                <td colspan ="5" align="center"><input type ="submit" name = "next" value = "Submit" style="height:30px;width:80px;font-size:15px;"/> </td>
              </tr>
          </table>
        </form>       
    </div>    
  </div>
</div>

</body>
</html>