<?php
class ActiveModule {
	// Module attr
	private $id;
	public $scheme = array();
	public $attributes = array();
	public $has_one = array();
	public $has_many = array();
	public $belongs_to = array();
	public $has_many_and_belongs_to = array();
	
	// constructor
	public function __construct($attrs = array())
	{
		$this->scheme = DBScheme::$tables[strtolower(get_class($this))];
		foreach ($attrs as $attr => $val) {
			if (!in_array($attr, $this->scheme)) {
				if ($attr == "id") {
					$this->id = $val;
				} else {
					die(get_class($this)." does not have \"".$attr."\" attributes");
				}	
			}
		}
		foreach ($this->scheme as $attr) {
			if (array_key_exists($attr, $attrs)) {
				$this->attributes[$attr] = $attrs[$attr];
			} else {
				$this->attributes[$attr] = NULL;
			}
		}
	}
	
	// save to db
	public function save($forgein_key_name = NULL, $forgein_key_value = NULL)
	{
		if (!isset($this->id)) {
			$fields = array();
			foreach ($this->attributes as $attr => $val) {
				$fields["`{$attr}`"] = "'{$val}'";
			};
			if ($forgein_key_name != NULL) {
				if (in_array($forgein_key_name, $this->belongs_to)) {
					$fields["`".$forgein_key_name."_id`"] = $forgein_key_value;
				}
			}
			print_r($forgein_key_name);
			print_r($forgein_key_value);
			print_r("\n");
			$sql = "INSERT INTO `".DBScheme::$db_name."`.`".
					strtolower(get_class($this)).
					"` (".implode(',',array_keys($fields)).") ".
					"VALUES (".implode(',',$fields).");";
			print_r($sql);
			mysql_query($sql);
			$this->id = mysql_insert_id();
			return $this;
		} else {
			// UPDATE
		}
	}
	
	// get_id
	public function get_id()
	{
		if (isset($this->id)) {
			return $this->id;
		} else {
			return false;
		}
	}
	
	// __call
	public function __call($method, $args)
	{
		// find_by_
		if (preg_match("/^(find_by_)(.*)/", $method, $matches)) {
			$objects = array();
			$sql = "SELECT * FROM `".strtolower(get_class($this))."`
					WHERE `".$matches[2]."` = '".$args[0]."';";
			$result = mysql_query($sql);
			$num_rows = mysql_num_rows($result);
			for ($i=0; $i < $num_rows; $i++) {
				$row = mysql_fetch_array($result);
				$new_row = array();
				foreach ($row as $key => $value) {
					if (!is_int($key)) {
						$new_row[$key] = $value;
					}
				}
				$class_name = get_class($this);
				$object = new $class_name($new_row);
				array_push($objects, $object);
			}
			return $objects;
		}
		// add_
		else if (preg_match("/^(add_)(.*)/", $method, $matches)) {
			if (in_array($matches[2], $this->has_many)) {
				$args[0]->save(strtolower(get_class($this)), $this->id);
			} else {
				die("Can not add this relationship");
			}
		}
	}
	
	// __get
	public function __get($val_name)
	{
		if (in_array($val_name, $this->has_many) && isset($this->id)) {
			$target_class_name = ucfirst($val_name);
			$helper = new $target_class_name();
			return $helper->find_by_event_id($this->id);
		} else {
			die(get_class($this)." does not have \"".$val_name."\" relationship || object haven't been saved in database");
		}
	}
}






// $event = new Event(array(
// 	"name" => "He Qiao",
// 	"date" => "2012-10-12"
// ));
// $event->save();
// // print_r($event->find_by_name("He Qiao"));
// 
// $session = new Session(array(
// 	"title" => "Shi Rui"
// ));
// 
// $event->add_session($session);
// 
// print_r($event->get_id());
// print_r($event->session);
// print_r($session->get_id());
