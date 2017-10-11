<?php

	function Connection(){
		$db="data_sensor";
	   	
		$connection = mysql_connect('localhost', 'root');

		if (!$connection) {
	    	die('MySQL ERROR: ' . mysql_error());
		}
		
		mysql_select_db($db) or die( 'MySQL ERROR: '. mysql_error() );

		return $connection;
	}
?>
