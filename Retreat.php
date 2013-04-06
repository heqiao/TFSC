<?php include("header.php");?>
<!doctype html>
<html lang="en">
<head>
</head>
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
		<h1>Teaching Retreat Evaluation Form</h1>
		<p>In the past we have relied on feedback from our participants to change and enhance aspects of this program. Now we are
		  asking for your help. Feel free to make comments beyond those requested on any aspect of the retreat. (That's what the
		  lower half of the back page is for!) We thank you in advance for giving us this important feedback and hope you had a
		  great time at camp!</p>

		<form id="form" name="form" method= "POST" action="<?php echo $_SERVER['PHP_SELF'];?>">
		  <table align="center" witdh="100%">
		  <?php
			//set variable query for a query statement
			$query1 = "select question_id, description, question_flag, number_of_choice from question where event_type = 'RETREAT' and `Group` = 'ACCOMMODATION' order by `order`;"; 
			$title1 = "I. Accommodations";

			$query2 = "select question_id, description, question_flag, number_of_choice from question where event_type = 'RETREAT' and `Group` = 'PROGRAM' order by 'order';";
			$title2 = "II. Program";

			$query3 = "select question_id, description, question_flag, number_of_choice from question where event_type = 'RETREAT' and `Group` = 'INDIVIDUAL' order by 'order';";
			$title3 = "III. Individual Segments - please rate from 1 = Needs Improvement to 5 = Excellent";

			$query4 = "select question_id, description, question_flag, number_of_choice from question where event_type = 'RETREAT' and `Group` = 'GENERIC' order by 'order';";
			$title4 = "IV. Comments and Suggestions";            
						
		  Display($query1, $title1);
		  Display($query2, $title2); 
		  Display($query3, $title3); 
		  Display($query4, $title4); 

		  function Display($query, $title)
		  {           
			//Connection string 
			$connection = mysql_connect("localhost","root", "");
			//Run the connection string to connecct to the databse
			mysql_select_db("tfscdb", $connection) or die("Cannot open the database");
			//execute the query           
			$result = mysql_query($query, $connection) or die ("Could not execute sql: $query");
			// get result record
			$num_rows = mysql_num_rows($result);

			//print titles
			echo "<tr><td colspan = '6'><strong>$title</strong></br></br></td></tr>";
			//read questions from database
			for($i=1;$i<=$num_rows;$i++)
			{               
				echo "<tr><td colspan = '6'>";
				$row = mysql_fetch_array($result);
				echo $i;
				echo ". ";
				echo $row['description'];
				echo "</td></tr><tr><td height = '7px'></td></tr><tr>";  

				//determine question format according to question flag
				if($row['question_flag'] == 'R')
				{
				  if ($row['number_of_choice'] == 2) 
				  {  
					//$name = $title.$i;                 
					echo "<td width='120px'>Yes <input type = 'radio' name = '$row[question_id]' value = ''></td>";
					echo "<td width='120px'>No <input type = 'radio' name = '$row[question_id]' value = ''></td>";
					if (isset($_POST['submit'])) {    
					  if (!isset($_POST[$row['question_id']]))                
						echo "<td colspan = '4'><strong style='color: red;'>Please answer this question.</strong></td>";
					}
				  }                  
				  else
				  {
					//$name1 = $title.$i; 
					for ($j=0; $j < $row['number_of_choice']; $j++) 
					{ 
					  echo "<td width='120px'>";
					  echo $j+1;
					  echo "<input type = 'radio' name ='$row[question_id]' value = ''>";
					  echo "</td>";
					}
					if (isset($_POST['submit'])) {    
					  if (!isset($_POST[$row['question_id']]))                
						echo "<td colspan = '4'><strong style='color: red;'>Please answer this question.</strong></td>";
					}
				  } 
				  echo "</tr>";            
				} 
				else if ($row['question_flag'] == 'C') 
				{
				  //$name2 = $title.$i;
				  echo "<td colspan ='6'><textarea name ='$row[question_id]' rows='3' cols='63'></textarea></td>";
				  if (isset($_POST['submit'])) {    
					  if (!isset($_POST[$row['question_id']]))                
						echo "<td colspan = '4'><strong style='color: red;'>Please answer this question.</strong></td></tr>";
					}              
				}
				else if($row['question_flag'] == 'B')
				{
				  if ($row['number_of_choice'] == 6) 
				  {
					//$name3 = $title.$i;
					for ($j=0; $j < $row['number_of_choice'] - 1; $j++) 
					{ 
					  echo "<td width='120px'>";
					  echo $j + 1;
					  echo "<input type = 'radio' name ='$row[question_id]' value = ''>";
					  echo "</td>";
					}
					
					echo "<td width='200px'>";
					echo "didn't attend";
					echo "<input type = 'radio' name ='$row[question_id]' value = ''>";
					echo "</td>";
					if (isset($_POST['submit'])) {    
					  if (!isset($_POST[$row['question_id']]))                
						echo "<td colspan = '4'><strong style='color: red;'>Please answer this question.</strong></td></tr>";
					}
					echo "<tr><td colspan ='6'><textarea name ='text'.$row[question_id] rows='3' cols='63'></textarea></td>";
					if (isset($_POST['submit'])) {    
					  if (!isset($_POST['text'.$row['question_id']]))                
						echo "<td colspan = '4'><strong style='color: red;'>Please answer this question.</strong></td></tr>";
					} 
				  }
				  else if ($row['number_of_choice'] == 5) 
				  {
					//$name4= $title.$i;
					for ($j=0; $j < $row['number_of_choice']; $j++) 
					{ 
					  echo "<td width='120px'>";
					  echo $j + 1;
					  echo "<input type = 'radio' name ='$row[question_id]' value = ''>";
					  echo "</td>";
					}
					if (isset($_POST['submit'])) {    
					  if (!isset($_POST[$row['question_id']]))                
						echo "<td colspan = '4'><strong style='color: red;'>Please answer this question.</strong></td>";
					}
					echo "</tr>";
					echo "<tr><td colspan ='6'><textarea name =$row[question_id] rows='3' cols='63'></textarea></td>";
					if (isset($_POST['submit'])) {    
					  if (!isset($_POST[$row['question_id']]))                
						echo "<td colspan = '4'><strong style='color: red;'>Please answer this question.</strong></td></tr>";
					} 
				  } 
				}
				echo "<tr><td height = '20px'></td></tr>";          
			}
			//Close the connection to the database   
			mysql_close();
		  }
		  function SessionDisplay()
		  {
			//Connection string 
			$connection = mysql_connect("localhost","root", "");
			//Run the connection string to connecct to the databse
			mysql_select_db("tfscdb", $connection) or die("Cannot open the database");
			//execute the query           
			$result = mysql_query($query, $connection) or die ("Could not execute sql: $query");
			// get result record
			$num_rows = mysql_num_rows($result);

			//print titles
			echo "<tr><td colspan = '6'><strong>$title</strong></br></br></td></tr>";
			//read questions from database
			for($i=0;$i<$num_rows;$i++)
			{
				echo "<tr><td colspan = '6'>";
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
					echo "<td width='120px'>Yes <input type = 'radio' name ='$row[Session_ID]' value = '$row[Session_ID]'></td>";
					echo "<td width='120px'>No <input type = 'radio' name ='$row[Session_ID]' value = '$row[Session_ID]'></td>";
				  }                  
				  else
				  {
					for ($j=0; $j < $row['number_of_choice']; $j++) 
					{ 
					  echo "<td width='120px'>";
					  echo $j + 1;
					  echo "<input type = 'radio' name ='$row[Session_ID]' value = '$row[Session_ID]'>";
					  echo "</td>";
					}
				  } 
				  echo "</tr>";                
				} 
				else if ($row['question_flag'] == 'C') 
				{
				  echo "<td colspan ='6'><textarea rows='3' cols='63'></textarea></td></tr>";                
				}
				else if($row['question_flag'] == 'B')
				{
				  if ($row['number_of_choice'] == 6) 
				  {
					for ($j=0; $j < $row['number_of_choice'] - 1; $j++) 
					{ 
					  echo "<td width='120px'>";
					  echo $j + 1;
					  echo "<input type = 'radio' name ='$row[Session_ID]' value = '$row[Session_ID]'>";
					  echo "</td>";
					}
					echo "<td width='200px'>";
					echo "didn't attend";
					echo "<input type = 'radio' name ='$row[Session_ID]' value = '$row[Session_ID]'>";
					echo "</td></tr>";
					echo "<tr><td colspan ='6'><textarea rows='3' cols='63'></textarea></td></tr>";
				  }
				  else if ($row['number_of_choice'] == 5) 
				  {
					for ($j=0; $j < $row['number_of_choice']; $j++) 
					{ 
					  echo "<td width='120px'>";
					  echo $j + 1;
					  echo "<input type = 'radio' name ='$row[Session_ID]' value = '$row[Session_ID]'>";
					  echo "</td>";
					}
					echo "</tr>";
					echo "<tr><td colspan ='6'><textarea rows='3' cols='63'></textarea></td></tr>";
				  } 
				}
				echo "<tr><td height = '20px'></td></tr>";          
			}
			//Close the connection to the database   
			mysql_close();
		  }
		  ?>                   
			  <tr>
				<td height = "40px"></td>
			  </tr>
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