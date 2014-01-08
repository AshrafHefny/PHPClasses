<?php

include 'database.php';

// insert select update delete
$db = DB::getInstance();

// select * from tbl_name where col = 'value'
/*
$db->query('select *','users',$where = array(
		'name',
		'=',
		'Ali'
	));

$db->delete('users', array(
		'name', 
		'=',
		'Ali'
	));
*/
$db->deleteById('users', 5);