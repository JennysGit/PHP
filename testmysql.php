<?php 
$link = mysqli_connect('172.17.70.114','jenny','jenny'); 
if (!$link) { 
	die('Could not connect to MySQL: ' . mysql_error()); 
} 
echo 'Connection OK'; mysqli_close($link); 
?> 