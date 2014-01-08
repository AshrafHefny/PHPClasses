<?php

require_once('validate.php');

if(isset($_POST['submit'])){
	$validate = new validate();

	$validate->check('post',array(
		'name' =>array(
			'required' => true,
			'min' 	   => 3,
			'max'	   => 10,
			'is_exists' => 'users'

		),
		'password'   => array(
			'required'   => true,
			'min'		 => 5,
			'storng'
		),
		'password_again'	=> array(
			'required'	 =>true,
			'match'	   => 'password'
		),
		'email'	=>array(
			'required'	=> true,
			'email' => true
		),
		're_email'	=>array(
			'required'	=> true,
			'match'		=> 'email'
		),
		'url'	=> array(
			'url' => true
		)
	));
if($validate->ok()){
	echo "success";
}else{
	foreach ($validate->errors() as $error) {
		echo "<li>{$error}</li>";
	}
}

	
}

?>

<form action="" method="post">

	<div class="field">
		<label for="username">Username</label>
		<input type="text" name="name" />
	</div>

	<div class="field">
		<label for="password">Password</label>
		<input type="password" name="password" />
	</div>

	<div class="field">
		<label for="password_again">Re_Password</label>
		<input type="password" name="password_again" />
	</div>
	<div class="field">
		<label for="email">Email</label>
		<input type="text" name="email" />
	</div>
	<div class="field">
		<label for="email">Re_Email</label>
		<input type="text" name="re_email" />
	</div>
	<div class="field">
		<label for="Url">Your site</label>
		<input type="text" name="url" />
	</div>
	
	<input type="submit" name="submit" />
</form>