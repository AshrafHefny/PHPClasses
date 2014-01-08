<?php

require_once('input.class.php');

if(Input::exists('get')){
	Input::get('username');
	echo "<br />".Input::get('email');
	echo "<br />";
	Input::get('password');
}else{
	echo "Error";
}
?>

<form action="" method="get">
	
	<div class="filed">
		<label for="uasername">Username</label>
		<input type="text" name="username" />
	</div>

	<div class="filed">
		<label for="email">Email</label>
		<input type="text" name="email" />
	</div>
	<div class="filed">
		<label for="password">Password</label>
		<input type="text" name="password" />
	</div>

	<input type="submit" />

</form>