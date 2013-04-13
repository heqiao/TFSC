<?php
// Event class
// class Event {

// 	public $event_attr = Array();
// 	public $id = NULL;

// 	public function __construct($post){
// 		$this->event_attr = PostParse($post);
		
// 	// echo '<pre>';
// 	// print_r($this->event_attr);
// 	// echo '</pre>';
// 		$this->insertEvent($this->event_attr);
		
// 	}
// 	public function insertEvent($attr){
// 		global $eventType;
// 		$eventName         = strip_tags(trim($attr["eventName"]));
// 		$datepicker        = strip_tags(trim($attr["datepicker"]));
// 		$eventLoc          = strip_tags(trim($attr["eventLoc"]));
// 		$eventDesc         = strip_tags(trim($attr["Description"]));
// 		// $eventType         = strip_tags(trim($attr["selectType"]));
// 		$eventStart        = strip_tags(trim($attr["eventStart"]));
// 		$eventEnd          = strip_tags(trim($attr["eventEnd"]));
// 		$eventContactName  = strip_tags(trim($attr["eventContactName"]));
// 		$eventContactEmail = strip_tags(trim($attr["eventContactEmail"]));
// 		$eventContactPhone = strip_tags(trim($attr["eventContactPhone"]));

// 		$sql1 = "INSERT INTO `tfscdb`.`event`
// 					(`Name`, `Date`, `Location`, `Event_Type`, `Description`, 
// 					`Start_Time`, `End_Time`, `Contact_Name`, `Contact_Email`, 
// 					`Contact_Phone`)
// 					VALUES ('$eventName', '$datepicker', '$eventLoc', 
// 					'$evenType', '$eventDesc', '$eventStart', '$eventEnd', 
// 					'$eventContactName', '$eventContactEmail', 
// 					'$eventContactPhone');";
// 		$result = mysql_query($sql1) or die ("Could not excute sql $sql1");
// 		$this->id = mysql_insert_id();
// 	}
// 	public function insertSession($sessions){
// 		foreach ($sessions as $key => $session) {

// 	// echo '<pre>';
// 	// print_r($sessions);
// 	// echo '</pre>';
// 			$sessionDesc  = strip_tags(trim($session["sessionDesc"]));
// 			// $sessionOrder = strip_tags(trim($session["sessionOrder"]));
// 			//$sessionType = strip_tags(trim($session["session_type"]));
			
// 	// echo '<pre>';
// 	// print_r($this->id);
// 	// echo '</pre>';
// 			$sql2 = "INSERT INTO `tfscdb`.`session` (`Title`, `Event_ID`, `Group_Name`, `Order`) 
// 					VALUES ('$sessionDesc', '$this->id', '$sessionType', '$sessionOrder');";
// 	// echo '<pre>';
// 	// print_r($sql2);
// 	// echo '</pre>';
					
// 			$result = mysql_query($sql2) or die ("Could not excute sql $sql2");
// 			if (mysql_query('BEGIN')) {
// 				// Both of the queries work. Commit
// 				if (mysql_query($sql1) && mysql_query($sql2))
// 				{
// 					mysql_query('COMMIT');
// 				} 
// 				else
// 				{
// 					// Queries failed, no changes
// 					mysql_query('ROLLBACK'); 
// 				}
// 			}

// 		}
// 	}

// }

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

class Encryption {
	var $skey 	= "SuPerEncKey2010"; // you can change it
	
    public  function safe_b64encode($string) {
	
        $data = base64_encode($string);
        $data = str_replace(array('+','/','='),array('-','_',''),$data);
        return $data;
    }

	public function safe_b64decode($string) {
        $data = str_replace(array('-','_'),array('+','/'),$string);
        $mod4 = strlen($data) % 4;
        if ($mod4) {
            $data .= substr('====', $mod4);
        }
        return base64_decode($data);
    }
	
    public  function encode($value){ 
		
	    if(!$value){return false;}
        $text = $value;
        $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_ECB);
        $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
        $crypttext = mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $this->skey, $text, MCRYPT_MODE_ECB, $iv);
        return trim($this->safe_b64encode($crypttext)); 
    }
    
    public function decode($value){
		
        if(!$value){return false;}
        $crypttext = $this->safe_b64decode($value); 
        $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_ECB);
        $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
        $decrypttext = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $this->skey, $crypttext, MCRYPT_MODE_ECB, $iv);
        return trim($decrypttext);
    }
}
?>
<!-- 
[session] => Array
        (
            [(session_1)sessionDesc] => d1
            [(session_1)(speaker)(speaker_1)sessionSpeaker] => s1
            [(session_1)(speaker)(speaker_2)sessionSpeaker] => s2
            [(session_1)(speaker)(speaker_3)sessionSpeaker] => s3
            [(session_2)sessionDesc] => d2
            [(session_2)(speaker)(speaker_4)sessionSpeaker] => s11
            [(session_2)(speaker)(speaker_5)sessionSpeaker] => s22
        ) -->
