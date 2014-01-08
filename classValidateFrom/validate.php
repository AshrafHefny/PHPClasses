<?php

class validate{
	private $_connect,
			$_selectDb,
			$_ok = false,
			$_errors = array();

	const HOST     = 'localhost';
	const USER 	   = 'root';
	const PASSWORD = 'root';
	const DB 	   = 'test';

	public function __construct(){
		$this->_connect = mysql_connect(self::HOST,self::USER,self::PASSWORD) or die(mysql_error());

        $this->_selectDb = mysql_select_db(self::DB) or die(mysql_error());

	}

	
	public function check($source , $items = array()){
		foreach ($items as $item => $rules) {
			foreach ($rules as $rule => $rule_value) {

				if($source == 'post'){
					$value = trim($_POST[$item]);
				}elseif($source == 'get'){
					$value = trim($_GET[$item]);
				}

				if($rule == 'required' && empty($value)){
					$this->addError("{$item} is required ");
				}elseif(!empty($value)){
					switch ($rule) {
						case 'min':
							if(strlen($value) < $rule_value){
								$this->addError("{$item} must be a minmum of {$rule_value}");
							}
							break;
						case 'max':
							if(strlen($value) > $rule_value){
								$this->addError("{$item} must be a maxmum of {$rule_value}");
							}
							break;
						case 'match':
							if($source == 'post'){
								if($value != $_POST[$rule_value]){
									$this->addError("{$item} is not match the {$rule_value}");
								}
							}elseif($source == 'get'){
								if($value != $_GET[$rule_value]){
									$this->addError("{$item} is not match the {$rule_value}");
								}
							}
							break;
							case 'email':
								if(!filter_var($value, FILTER_VALIDATE_EMAIL)){
									$this->addError("{$value} is not email ");
								}
							break;
							case 'is_exists':
								$sql = "SELECT * FROM `{$rule_value}` WHERE `{$item}` = '{$value}'";
								$query = mysql_query($sql) or die(mysql_error());
								$num = mysql_num_rows($query);
								if($num){
									$this->addError("Email Already Exists");
								}

							break;
							case 'url':
								if(!filter_var($value, FILTER_VALIDATE_URL)){
									$this->addError("{$value} is not URL ");
								}

							break;

						
					}
				}


			}	
		}
		if(empty($this->_errors)){
			$this->_ok = true;
		}

		return $this;
		
	}

	public function addError($error){
		$this->_errors[] = $error;
	}

	public function errors(){
		return $this->_errors;
	}

	public function ok(){
		return $this->_ok;
	}
	
	
}