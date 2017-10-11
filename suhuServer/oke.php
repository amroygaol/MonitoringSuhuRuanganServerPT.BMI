<?php

	$link = mysql_connect('localhost', 'root');
	$db_selected = mysql_select_db('data_sensor', $link);
	$sql = "INSERT INTO templog(tempServer1, tempServer2) VALUES ('".$_GET["temp1"]."','".$_GET["temp2"]."')";
	$result = mysql_query($sql);
	if($result){
		header('location: index.php');
	}
	else{
	echo "error";
	}
?>