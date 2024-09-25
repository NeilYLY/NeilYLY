<?php
	$id=(int)$_REQUEST['id'];
	$tem=(float)$_REQUEST['tem'];//溫度
	$dirty=(float)$_REQUEST['dirty'];//混濁度
	$ph=(float)$_REQUEST['ph'];//ph值
	$ec=(float)$_REQUEST['ec'];//導電度
	$time=time();
	$Q="insert into data select max(id)+1,'${tem}','${dirty}','${ph}','${ec}',now() from data ";
	$link = new PDO('mysql:dbname=h801;host=localhost;','h801','M7rtPka5#');
	$result=$link->query($Q);
	
?>

