<?php
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