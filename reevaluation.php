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
		<center><h3><?php echo $bigTitle;?> Form</h3></center>
		<p>In the past we have relied on feedback from our participants to change and enhance aspects of this program. Now we are
		  asking for your help. Feel free to make comments beyond those requested on any aspect of the retreat. (That's what the
		  lower half of the back page is for!) We thank you in advance for giving us this important feedback and hope you had a
		  great time at camp!</p>
	<!-- Form to post data-->
		<form id="form" name="form" method= "POST" class="form" action="reevaluation.php?id=<?php echo $encode;?>">
		  <?php
		  	//Variable to check if all required fields are filled, when false will show reminder to answer
      		$check = true;
			//set variable query for query statements
			$query1 = "select id, description, question_flag, number_of_choices, group_description, `group` from question where event_type = 'RETREAT' and `group` = 'ACCOMMODATION' order by `order`;"; 

			$query2 = "select id, description, question_flag, number_of_choices, group_description, `group` from question where event_type = 'RETREAT' and `group` = 'PROGRAM' order by 'order';";

			$query3 = "select id, description, question_flag, number_of_choices, group_description, `group` from question where event_type = 'RETREAT' and `group` = 'INDIVIDUAL' order by 'order';";

			$query4 = "select id, description, question_flag, number_of_choices, group_description, `group` from question where event_type = 'RETREAT' and `group` = 'GENERIC' order by 'order';";   

		  //display questions for each part				
		  Display($query1);
		  Display($query2); 
		  Display($query3); 
		  Display($query4);
		  //insert answers into database
		  Insert($query1);
		  Insert($query2); 
		  Insert($query3); 
		  Insert($query4);
		  

		  function Display($query)
		  {      
		  		global $id;     
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
				echo "<h5>".$titlerow['group_description']."</h5>";
				if ($titlerow['group'] == "INDIVIDUAL") {
					//useful queries
					$query1 = "select * from session where event_id = $id;";
					//execute the query           
					$result1 = mysql_query($query1, $connection) or die ("Could not execute sql: $query1");
					// get result record
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
					if ($row['group_name'] == null) {	
						echo "<p>";
						echo $i + 1;
						echo ". ";
						echo $row['title']."</p>";
						$indQuesID = "Indi".$row['id'];
						sessionQuestion($indQuesID);
					}
					else {
						if ($row['group_name'] != $groupName) {		
							$groupName = $row['group_name'];
							echo "<h5>$groupName</h5>";
							$groupQuery = "select * from session where group_name = '$groupName' order by `order`;";
								
							$groupResult = mysql_query($groupQuery, $connection) or die ("Could not execute sql: $groupQuery");	
							$groupResult1 = mysql_query($groupQuery, $connection) or die ("Could not execute sql: $groupQuery");	
							// get number of results
							$num_groupRows = mysql_num_rows($groupResult);				
							//set dropdown list name
							$groupRow1 = mysql_fetch_array($groupResult1);
							//dropdown list
							$selectname = "select".$groupRow1['id'];
							echo "<select class = 'span12' name = '$selectname'>";
							echo "<option value = '0'>Choose Session</option>";
							for ($h=0; $h < $num_groupRows; $h++) { 
								$groupRow = mysql_fetch_array($groupResult);
								echo "<option value = '$groupRow[id]' ";
								 if ($_POST[$selectname] == $groupRow['id']) 
								 	echo "selected='selected'";
								echo ">".$groupRow['group_name']." - ".$groupRow['title']."</option>";
							}
							echo "</select>";
							//validation
							if (isset($_POST['submit'])) {    
								  if ($_POST[$selectname] == 0)   
								  {
								  	echo "<div class='alert alert-error'>Please select session you attended.</div>";
								  	global $check;
								  	$check = false;
								  }            
							}
							$indQuesID = "Indi".$groupRow1['id'];
							sessionQuestion($indQuesID);							
						}
					}									
				}
		  }
		 
		 function sessionQuestion($indQuesID)
		  {
				//validation
				if (isset($_POST['submit'])) {    
					  if (!isset($_POST[$indQuesID]))    
					  {
						echo "<div class='alert alert-error'>Please answer this question.</div>";	
						global $check;
						$check = false;				  	
					  }           
				}
				//dispay questions from database			
				for ($j=0; $j < 5; $j++) 
				{ 
			        $rate = $j+1;
			        echo "<label class='radio'><input type = 'radio' name = '$indQuesID' value = '$rate' ";
			        if ($_POST[$indQuesID] == $rate) 
			            echo "checked";
			         echo ">".$rate."</label>";			                            
				}
				$textarea = "textarea".$indQuesID;
				echo "<textarea class='span12' name ='$textarea' placeholder = 'Comments here...'></textarea>";	
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
					echo $row['description']."</p>";
					//validation
					if (isset($_POST['submit'])) 
					{    
						  if (!isset($_POST[$row['id']]))                
						  {
							echo "<div class='alert alert-error'>Please answer this question.</div>";	
							global $check;
							$check = false;				  	
						  }
					} 

					//determine question format according to question flag
					if($row['question_flag'] == 'R')
					{
					  if ($row['number_of_choices'] == 2) 
					  {  
						echo "<label class='radio'><input type = 'radio' name = '$row[id]' value = '1' ";
	                    if ($_POST[$row['id']] == '1') 
	                      echo "checked";
	                    echo "> Yes </label>";
	                    echo "<label class='radio'><input type = 'radio' name = '$row[id]' value = '2' ";
	                    if ($_POST[$row['id']] == '2') 
	                      echo "checked";
	                    echo "> No </label>";					
					  }                  
					  else
					  {
						for ($j=0; $j < $row['number_of_choices']; $j++) 
						{ 
	                      $rate = $j+1;
	                      echo "<label class='radio'><input type = 'radio' name ='$row[id]' value = '$rate' ";
	                      if ($_POST[$row['id']] == $rate) 
	                        echo "checked";
	                      echo ">".$rate."</label>";
						}
					  }           
					} 
					else if ($row['question_flag'] == 'C') 
					{
					  echo "<textarea class='span12' name ='$row[id]' placeholder = 'Comments here...'>";
					  if(isset($_POST[$row['id']]))
	                    {
	                       echo $_POST[$row['id']];
	                    }
	                    echo "</textarea>";        
					}     
				}
		  }
		function Insert($query)
		{
		  //When user clicks the submit button...
	      if (isset($_POST['submit'])) 
		  {	
		  	 global $check;
			 global $id;
		     if ($check == true) 
		     {

		     	//Connection string 
				$connection = mysql_connect("localhost","root", "");
				//Run the connection string to connecct to the databse
				mysql_select_db("tfscdb", $connection) or die("Cannot open the database");
				//execute the query           
				$result = mysql_query($query, $connection) or die ("Could not execute sql: $query");
				$titleresult = mysql_query($query, $connection) or die ("Could not execute sql: $query");
				// get the group description
				$titlerow = mysql_fetch_array($titleresult);
				// get result record
				$num_rows = mysql_num_rows($result);
				if ($titlerow['group'] == "INDIVIDUAL") 
				{
					//useful queries
					$query1 = "select * from session where event_id = $id;";
					//execute the query           
					$result1 = mysql_query($query1, $connection) or die ("Could not execute sql: $query1");
					// get result record
					$num_rows1 = mysql_num_rows($result1);
					$groupName = "";
					
					for ($i=0; $i < $num_rows1; $i++) 
					{ 				
						$row = mysql_fetch_array($result1);
						if ($row['group_name'] == null) {
							$indQuesID = "Indi".$row['id'];	
							$areatext = "areatext".$indQuesID;
							$answer1 = $_POST[$indQuesID];
							$answer2 = $_POST[$areatext];
		                    
		                    $sql1 = "insert into evaluation (`id`, `question_id`, `event_id`, `session_id`, `user_rating`, `user_comment`) values(null, 13, $id, $row[id], $answer1, null);";
		                    $insert = mysql_query($sql1, $connection) or die ("Could not execute sql $sql1");
		                    if ($answer2 != null) {
		                        $sql2 = "insert into evaluation (`id`, `question_id`, `event_id`, `session_id`, `user_rating`, `user_comment`) values(null, 16, $id, $row[id], null, '$answer2');"; 	
		                        $insert = mysql_query($sql2, $connection) or die ("Could not execute sql $sql2");	                                         
		                    }	
						}
						else {
							if ($row['group_name'] != $groupName) {		
								$groupName = $row['group_name'];
								$groupQuery = "select * from session where group_name = '$groupName' order by `order`;";
									
								$groupResult = mysql_query($groupQuery, $connection) or die ("Could not execute sql: $groupQuery");	
			
								//set dropdown list name
								$groupRow = mysql_fetch_array($groupResult);
								//dropdown list
								$selectname = "select".$groupRow['id'];
								$session = $_POST[$selectname];
								//get answer of the radio button and textarea
								$indQuesID = "Indi".$groupRow['id'];
								$areatext = "areatext".$indQuesID;
								$answer1 = $_POST[$indQuesID];
								$answer2 = $_POST[$areatext];

								//insert radio button rating into database
								$sql1 = "insert into evaluation (`id`, `question_id`, `event_id`, `session_id`, `user_rating`, `user_comment`) values(null, 13, $id, $session, $answer1, null);";
		                    	$insert = mysql_query($sql1, $connection) or die ("Could not execute sql $sql1");
		                    	//insert comments into database
			                    if ($answer2 != null) {
			                        $sql2 = "insert into evaluation (`id`, `question_id`, `event_id`, `session_id`, `user_rating`, `user_comment`) values(null, 16, $id, $session, null, '$answer2');"; 	
			                        $insert = mysql_query($sql2, $connection) or die ("Could not execute sql $sql2"); 	                    			
			                    }
			                    	
							  	                 
			                  }
			             }	
			           }
			    }		
				 else
				 {
					for ($i=0; $i < $num_rows; $i++) 
					{ 
						$row = mysql_fetch_array($result);                  
	                    $answer = $_POST[$row['id']];
	                    if ($row['question_flag'] == 'R')
	                    {
	                      $sql = "insert into evaluation (`id`, `question_id`, `event_id`, `session_id`, `user_rating`, `user_comment`) values(null, $row[id], $id, null, $answer, null);";
	                      $insert = mysql_query($sql, $connection) or die ("Could not execute sql: $sql");
	                    }else if ($row['question_flag'] == 'C') 
	                    {
	                      if ($answer != null) {
	                        $sql = "insert into evaluation (`id`, `question_id`, `event_id`, `session_id`, `user_rating`, `user_comment`) values(null, $row[id], $id, null, null, '$answer');";
	                        $insert = mysql_query($sql, $connection) or die ("Could not execute sql: $sql");
	                      }                  
                    	}							  	
                    }
				}
				echo "<script>location.href='thanks.php';</script>";
		  	}
	   	  }
		}
		?>          
			<label class="checkbox span11">	
				<input type="checkbox" name="checkbox" value ="yes" <?php if($_POST['checkbox'] == 'yes') echo "checked" ?>>
					<strong>Please check here if you are a first time camper.</strong>
 			</label>
				<center><button class ="btn" name = "submit"/>Submit</button></center>
		</form>       
	</div>    
  </div>
</div>
<?php require_once "_parts/html_foot.php";?>
</body>
</html>