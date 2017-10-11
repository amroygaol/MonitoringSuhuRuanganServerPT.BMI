<?php
   	include("connect.php");
   	
   	$link=Connection();

//	$temp1=$_POST["temp1"];
//	$hum1=$_POST["hum1"];

	$query = "INSERT INTO templog (tempServer1,tempServer2); 
		VALUES ('".$_GET["temp1"]."','".$_GET["hum1"]."')"; 
   	
   	$result = mysql_query($query,$link);
	
	if($result){
   	header("Location: index.php");
	}
	else{
		echo "error".$query . "<br>".$link->error;
	}
	mysql_close($link);
?>
