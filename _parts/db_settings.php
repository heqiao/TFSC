<?php
class DBScheme {
	// DB structure
	public static $db_name = "tfscdb";
	public static $tables = array(
		"event" => array(
			"name", 
			"date", 
			"location", 
			"event_type", 
			"description", 
			"start_time",
			"end_time",
			"contact_name",
			"contact_email",
			"contact_phone"
		),
		"session" => array(
			"event_id",
			"title",
			"group_name"
		),
		"session_speaker" => array(
			"speaker_id",
			"session_id"
		),
		"speaker" => array(
			"first_name",
			"last_name",
			"prefix",
			"title",
			"department",
			"organization"
		)
	);
	// db connection
	public static $con;
}

DBScheme::$con = mysql_connect("localhost","root", "123");
$connection = DBScheme::$con;
mysql_select_db(DBScheme::$db_name, DBScheme::$con) or die("No db!!!");


/**
* ActiveModule
*/

require_once "active_module.php";

class Event extends ActiveModule {
	public $has_many = array('session');
}

class Session extends ActiveModule {
	public $belongs_to = array('event');
}
