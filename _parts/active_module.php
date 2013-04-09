<?php
class ActiveModule {
	
	// Helper object
	protected $helper = false;
	protected $saved = false;

	// DB settings
	protected $scheme = array();
	
	// Attributes
	protected $id;
	protected $attributes = array();
	
	// Relationship
	protected $has_one = array();
	protected $has_many = array();
	protected $belongs_to = array();
	protected $has_many_and_belongs_to = array();
	
	// Constructor
	public function __construct($attrs = array())
	{
		// load db scheme
		$this->scheme = DBScheme::$tables[strtolower(get_class($this))];
		// init
		// this is a helper
		if ($attrs === true) {
			$this->helper = true;
		}
		// this is a module object
		else {
			foreach ($this->scheme as $attr) {
				$this->attributes[$attr] = NULL;
			}
			foreach ($attrs as $attr => $val) {
				if ($attr == "id") {
					$this->id = $val;
				} else if (in_array($attr, $this->scheme)) {
					$this->attributes[$attr] = $val;
				} else {
					die("ERROR: ".get_class($this)." does not have \"".$attr."\" attributes.");
				}
			}
		}
	}
	
	// __MAGIC__ methods
	// find_by_
	// add_
	public function __call($method, $args)
	{
		// find_by_
		if (preg_match("/^(find_by_)(.+)/", $method, $matches)) {
			$sql = "SELECT * FROM `".strtolower(get_class($this))."`
					WHERE `".$matches[2]."` = '".$args[0]."';";
			$result = mysql_query($sql);
			$num_rows = mysql_num_rows($result);
			// no result
			if ($num_rows == 0) {
				return array();
			}
			// has result 
			else {
				$objects = array();
				for ($i=0; $i < $num_rows; $i++) {
					$row = mysql_fetch_array($result);
					$row_cleaned = array();
					foreach ($row as $key => $value) {
						if (!is_int($key)) {
							$row_cleaned[strtolower($key)] = $value;
						}
					}
					$module_name = get_class($this);
					$object = new $module_name($row_cleaned);
					array_push($objects, $object);
				}
				return $objects;
			}
		}
		// add_
		else if (preg_match("/^(add_)(.+)/", $method, $matches)) {
			if (!in_array($matches[2], $this->has_many)) {
				die("ERROR: ".get_class($this)." do not have \"".$name."\" attribute.");
			} else {
				$forgein_key_name = strtolower(get_class($this)) . "_id";
				$args[0]->{$forgein_key_name} = $this->id;
				$args[0]->save();
				return $this;
			}
		}
	}

	// __set
	public function __set($name, $value)
	{
		if (!in_array($name, $this->scheme)) {
			die("ERROR: ".get_class($this)." do not have \"".$name."\" attribute.");
		} else if ($name == "id") {
			die("ERROR: id cannot be changed manually.");
		} else {
			$this->attributes[$name] = $value;
			$this->saved = false;
		}
	}

	// __get
	public function __get($name)
	{
		// attribute
		if (in_array($name, $this->scheme)) {
			return $this->attributes[$name];
			// die(get_class($this)." does not have \"".$name."\" attributes.");
		}
		else if ($name == "id") {
			return $this->id;
		}
		// has_one
		else if (isset($this->has_one) && in_array($name, $this->has_one)) {
			$this_module_name = ucfirst($name);
			$helper = new $this_module_name();
			$method_name = "find_by_".strtolower(get_class($this))."_id";
			$object = $helper->$method_name($this->id);
			if (empty($object)) {
				return $object[0];
			} else {
				return array();
			}
		}
		// has_many
		else if (isset($this->has_many) && in_array($name, $this->has_many)) {
			$targe_module_name = ucfirst($name);
			$helper = new $targe_module_name(true);
			$method_name = "find_by_".strtolower(get_class($this))."_id";
			return $helper->$method_name($this->id);
		}
		// belongs_to
		else if (isset($this->belongs_to) && in_array($name, $this->belongs_to)) {
			$targe_module_name = ucfirst($name);
			$helper = new $targe_module_name(true);
			$foreign_key = $name . "_id";
			$object = $helper->find_by_id($this->{$foreign_key});
			return $object[0];
		}
		// has_many_and_belongs_to
		else if (isset($this->has_many_and_belongs_to) && in_array($name, $this->has_many_and_belongs_to)) {
			$targe_module_name = ucfirst($name);
			$table_name_array = array($name, strtolower(get_class($this)));
			asort($table_name_array);
			$connection_table_name = implode("_", $table_name_array);
			
			// select * from speaker s right outer join session_speaker ss on s.id = ss.speaker_id where ss.session_id = your id 
			
			$sql = "SELECT * FROM `".DBScheme::$db_name."`.`$name` A RIGHT OUTER JOIN `".DBScheme::$db_name."`.`{$connection_table_name}` B ON A.id = B.{$name}_id WHERE B.".strtolower(get_class($this))."_id = {$this->id};";
			
			$result = mysql_query($sql);
			$num_rows = mysql_num_rows($result);
			// no result
			if ($num_rows == 0) {
				return array();
			}
			// has result 
			else {
				$objects = array();
				for ($i=0; $i < $num_rows; $i++) {
					$row = mysql_fetch_array($result);
					$row_cleaned = array();
					foreach ($row as $key => $value) {
						if (!(is_int($key) || strtolower($key) == strtolower(get_class($this))."_id" || strtolower($key) == "{$name}_id")) {
							$row_cleaned[strtolower($key)] = $value;
						}
					}
					print_r($row_cleaned);
					$object = new $targe_module_name($row_cleaned);
					array_push($objects, $object);
				}
				return $objects;
			}
		}
	}

	// Save
	public function save()
	{
		// update
		if (isset($this->id) && $this->saved === false) {
			
		}
		// insert
		else if ($this->saved === false) {
			$fields = array();
			foreach ($this->attributes as $attr => $val) {
				$fields["`{$attr}`"] = "'{$val}'";
			};
			$sql = "INSERT INTO `".DBScheme::$db_name."`.`".
					strtolower(get_class($this)).
					"` (".implode(',',array_keys($fields)).") ".
					"VALUES (".implode(',',$fields).");";
			mysql_query($sql);
			$this->id = mysql_insert_id();
			return $this;
		}
	}
}
