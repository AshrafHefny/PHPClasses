<?php

class Input{

	public static function exists($type = "post"){

		switch ($type) {
			case 'post':
				return (!empty($_POST)) ? true: false;
				break;
			case 'get':
				return (!empty($_GET))?true : false;
				break;
			default:
				return false;
				break;
		}

	}

	public static function get($name){
		if(isset($_POST[$name])){
			echo $_POST[$name];
		}elseif(isset($_GET[$name])){
			echo $_GET[$name];
		}
	}


}


