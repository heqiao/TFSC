<?php
//Event class
class Event {

	public $event_attr = Array();
	public $id = NULL;

	public function __construct($post, $connection){
		$this->event_attr = PostParse($post);
		
	// echo '<pre>';
	// print_r($this->event_attr);
	// echo '</pre>';
		$this->insertEvent($this->event_attr);
		
	}
	public function insertEvent($attr){
		global $connection;
		$eventName         = strip_tags(trim($attr["eventName"]));
		$datepicker        = strip_tags(trim($attr["datepicker"]));
		$eventLoc          = strip_tags(trim($attr["eventLoc"]));
		$eventDesc         = strip_tags(trim($attr["Description"]));
		$eventType         = strip_tags(trim($attr["selectType"]));
		$eventStart        = strip_tags(trim($attr["eventStart"]));
		$eventEnd          = strip_tags(trim($attr["eventEnd"]));
		$eventContactName  = strip_tags(trim($attr["eventContactName"]));
		$eventContactEmail = strip_tags(trim($attr["eventContactEmail"]));
		$eventContactPhone = strip_tags(trim($attr["eventContactPhone"]));

		$sql1 = "INSERT INTO `tfscdb`.`event`
					(`Name`, `Date`, `Location`, `Event_Type`, `Description`, 
					`Start_Time`, `End_Time`, `Contact_Name`, `Contact_Email`, 
					`Contact_Phone`)
					VALUES ('$eventName', '$datepicker', '$eventLoc', 
					'$eventType', '$eventDesc', '$eventStart', '$eventEnd', 
					'$eventContactName', '$eventContactEmail', 
					'$eventContactPhone');";
		$result = mysql_query($sql1, $connection) or die ("Could not excute sql $sql1");
		$this->id = mysql_insert_id($connection);
	}
	public function insertSession($sessions){
		global $connection;

		foreach ($sessions as $key => $session) {

	// echo '<pre>';
	// print_r($sessions);
	// echo '</pre>';
			$sessionDesc = strip_tags(trim($session["session_desc"]));
			$sessionType = strip_tags(trim($session["session_type"]));
			
	// echo '<pre>';
	// print_r($this->id);
	// echo '</pre>';
			$sql2 = "INSERT INTO `tfscdb`.`session` (`Title`, `Event_ID`, `Group_Name`, `Order`) 
					VALUES ('$sessionDesc', '$this->id', '$sessionType', '1');";
	// echo '<pre>';
	// print_r($sql2);
	// echo '</pre>';
					
			$result = mysql_query($sql2, $connection) or die ("Could not excute sql $sql2");
			if (mysql_query('BEGIN')) {
				// Both of the queries work. Commit
				if (mysql_query($sql1, $connection) && mysql_query($sql2, $connection))
				{
					mysql_query('COMMIT');
				} 
				else
				{
					// Queries failed, no changes
					mysql_query('ROLLBACK'); 
				}
			}

		}
	}

}
// Parse the form to array in hierachy
function PostParse($post)
{
	$params = Array();
	$regex = "/(\()(..*?)(\))(.*)/";
	
	// Find key
	$key_set = Array();
	foreach ($post as $key => $val) {
		if (preg_match($regex, $key, $matches)) {
			if (!in_array($matches[2], $key_set)) {
				array_push($key_set, $matches[2]);
			}
		}
		else {
			$params[$key] = $val;
		}
	}
	
	// Make array
	foreach ($key_set as $key) {
		$sub_regex = "/^(\($key\))(.*)/";
		$sub_params = Array();
		foreach ($post as $post_key => $post_val) {
			if (preg_match($sub_regex, $post_key, $matches)) {
				$sub_params[$matches[2]] = $post[$post_key];
			}
		}
		$params[$key] = $sub_params;
	}
	
	// Go deep
	foreach ($params as $key => $val) {
		if (is_array($val)) {
			$params[$key] = PostParse($val);
		}
	}
	
	// return
	return($params);
}
?>