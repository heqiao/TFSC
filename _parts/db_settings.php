<?php
class DBScheme {
	// DB structure
	public static $db_name = "tfsc";
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
			"group_name",
			"order"
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
	public static $connection;
}

DBScheme::$connection = mysql_connect("localhost","root", "");
$connection = DBScheme::$connection;
mysql_select_db(DBScheme::$db_name, DBScheme::$connection) or die("No db!!!");


/**
* ActiveModule
*/

require_once "active_module.php";

class Event extends ActiveModule {
	protected $has_many = array('session');
}

class Session extends ActiveModule {
	protected $belongs_to = array('event');
	protected $has_many_and_belongs_to = array('speaker');
}

class Speaker extends ActiveModule {
	protected $has_many_and_belongs_to = array('session');
}
