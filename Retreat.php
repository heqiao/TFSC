<?php
require_once "_parts/functions.php";
//require_once "_parts/db_settings.php";

// HTML parts
require_once "_parts/html_head.php";
require_once "_parts/header.php";
?>
<!doctype html>
<html lang="en">
<head>
</head>
<body>
<div class="container">
  <div class ="row-fluid">
    <div class = "span7 offset2">

	<!-- Form to post data-->
	<div class="sixcol centerPlate">
		<center><h3>Teaching Retreat Evaluation Form</h3></center>
		<p>In the past we have relied on feedback from our participants to change and enhance aspects of this program. Now we are
		  asking for your help. Feel free to make comments beyond those requested on any aspect of the retreat. (That's what the
		  lower half of the back page is for!) We thank you in advance for giving us this important feedback and hope you had a
		  great time at camp!</p>

		<form id="form" name="form" method= "POST" class="form" action="<?php echo $_SERVER['PHP_SELF'];?>">
		  <?php
			//set variable query for query statements
			$query1 = "select Question_ID, Description, Question_Flag, Number_of_Choices, Group_Description, `Group` from question where Event_Type = 'RETREAT' and `Group` = 'ACCOMMODATION' order by `Order`;"; 

			$query2 = "select Question_ID, Description, Question_Flag, Number_of_Choices, Group_Description, `Group` from question where Event_Type = 'RETREAT' and `Group` = 'PROGRAM' order by 'Order';";

			$query3 = "select Question_ID, Description, Question_Flag, Number_of_Choices, Group_Description, `Group` from question where Event_Type = 'RETREAT' and `Group` = 'INDIVIDUAL' order by 'Order';";

			$query4 = "select Question_ID, Description, Question_Flag, Number_of_Choices, Group_Description, `Group` from question where Event_Type = 'RETREAT' and `Group` = 'GENERIC' order by 'Order';";   

						
		  Display($query1);
		  Display($query2); 
		  Display($query3); 
		  Display($query4); 
		  

		  function Display($query)
		  {           
			//Connection string 
			$connection = mysql_connect("localhost","root", "");
			//Run the connection string to connecct to the databse
			mysql_select_db("tfscdb", $connection) or die("Cannot open the database");
			//execute the query           
			$titleresult = mysql_query($query, $connection) or die ("Could not execute sql: $query");
			$result = mysql_query($query, $connection) or die ("Could not execute sql: $query");
			// get result record
			$num_rows = mysql_num_rows($result);
			// get the group description
			$titlerow = mysql_fetch_array($titleresult);
			//display titles
			echo "<h5>".$titlerow['Group_Description']."</h5>";
			if ($titlerow['Group'] == "INDIVIDUAL") {
				//useful queries
				$query1 = "select * from session where Event_ID = 3;";
				//execute the query           
				$result1 = mysql_query($query1, $connection) or die ("Could not execute sql: $query1");
				// get result record
				$num_rows = mysql_num_rows($result);
				$num_rows1 = mysql_num_rows($result1);
				readSession($num_rows1, $result1);
			}
			else
			{
				readQuestion($num_rows, $result);
			}
		  }
		  function readSession($num_rows, $result)
		  {
		  	//Connection string 
			$connection = mysql_connect("localhost","root", "");
			//Run the connection string to connecct to the databse
			mysql_select_db("tfscdb", $connection) or die("Cannot open the database");
			$groupName = "";
			for ($i=0; $i < $num_rows; $i++) 
			{ 				
				$row = mysql_fetch_array($result);
				if ($row['Group_Name'] == null) {	
					echo "<p>";
					echo $i + 1;
					echo ". ";
					echo $row['Title']."</p>";
					sessionQuestion($row['Session_ID']);
				}
				else {
					if ($row['Group_Name'] != $groupName) {						
						echo "<h5>Optional Session: </h5>";
						$groupName = $row['Group_Name'];
						$groupQuery = "select * from session where Group_name = '$groupName' order by `Order`;";
						$groupResult = mysql_query($groupQuery, $connection) or die ("Could not execute sql: $groupQuery");						
						// get result record
						$num_groupRows = mysql_num_rows($groupResult);
						$selectname = "select".$groupRow['Session_ID'];
						echo "<select class = 'span12' name = '$selectname'>";
						echo "<option value = '0'>Choose Session</option>";
						for ($h=0; $h < $num_groupRows; $h++) { 
							$rate = $h + 1;
							$groupRow = mysql_fetch_array($groupResult);
							echo "<option value = '$rate' ";
							 if ($_POST[$selectname] == $rate) 
							 	echo "selected='selected'";
							echo ">".$groupRow['Title']."</option>";
						}
						echo "</select>";
						//validation
						if (isset($_POST['submit'])) {    
							  if ($_POST[$selectname] == 0)               
			                     echo "<div class='alert alert-error'>Please answer this question.</div>";
						}
						sessionQuestion($groupRow['Session_ID']);							
					}
				}									
			}
		 }
		 function sessionQuestion($sessionID)
		  {
				//validation
				if (isset($_POST['submit'])) {    
					  if (!isset($_POST[$sessionID]))               
						echo "<div class='alert alert-error'>Please answer this question.</div>";
				}
				//dispay questions from database			
				for ($j=0; $j < 5; $j++) 
				{ 
			        $rate = $j+1;
			        echo "<label class='radio'><input type = 'radio' name = '$sessionID' value = '$rate' ";
			        if ($_POST[$sessionID] == $rate) 
			            echo "checked";
			         echo ">".$rate."</label>";			                            
				}
				$textarea = "textarea".$sessionID;
				echo "<textarea class='span12' name ='$testarea' placeholder = 'Comments here...'></textarea>";	
		  }

		  function readQuestion($num_rows, $result)
		  {
		  	//read questions from database
			for($i=0;$i<$num_rows;$i++)
			{               
				$row = mysql_fetch_array($result);
				echo "<p>";
				echo $i + 1;
				echo ". ";
				echo $row['Description']."</p>";
				//validation
				if (isset($_POST['submit'])) {    
					  if (!isset($_POST[$row['Question_ID']]))                
						echo "<div class='alert alert-error'>Please answer this question.</div>";
				} 

				//determine question format according to question flag
				if($row['Question_Flag'] == 'R')
				{
				  if ($row['Number_of_Choices'] == 2) 
				  {  
					echo "<label class='radio'><input type = 'radio' name = '$row[Question_ID]' value = '1' ";
                    if ($_POST[$row['Question_ID']] == '1') 
                      echo "checked";
                    echo "> Yes </label>";
                    echo "<label class='radio'><input type = 'radio' name = '$row[Question_ID]' value = '2' ";
                    if ($_POST[$row['Question_ID']] == '2') 
                      echo "checked";
                    echo "> No </label>";					
				  }                  
				  else
				  {
					for ($j=0; $j < $row['Number_of_Choices']; $j++) 
					{ 
                      $rate = $j+1;
                      echo "<label class='radio'><input type = 'radio' name ='$row[Question_ID]' value = '$rate' ";
                      if ($_POST[$row['Question_ID']] == $rate) 
                        echo "checked";
                      echo ">".$rate."</label>";
					}
				  }           
				} 
				else if ($row['Question_Flag'] == 'C') 
				{
				  echo "<textarea class='span12' name ='$row[Question_ID]' placeholder = 'Comments here...'></textarea>";           
				}     
			  }
		  	}
		?>          
				
			<input class = 'checkbox' type="checkbox" name="checkbox" value ="yes" <?php if($_POST['checkbox'] == 'yes') echo "checked" ?>> 
				      <strong>Please check here if you are a first time camper.</strong>
 
				<center><button class ="btn" name = "submit"/>Submit</button></center>
		</form>       
	</div>    
  </div>
</div>
<?php require_once "_parts/html_foot.php";?>
</body>
</html>