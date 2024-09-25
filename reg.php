<!doctype html>
<html lang="zh_tw">
<head>
<meta charset="utf-8">
<script>

</script>
<title>註冊結果</title>
</head>
<body>
<h3>註冊結果</h3>
<?php
	$name=str_replace("'","''",$_REQUEST['name']);
	$pwd1=str_replace("'","''",$_REQUEST['pwd1']);
	$pwd2=str_replace("'","''",$_REQUEST['pwd2']);
	$mobile=str_replace("'","''",$_REQUEST['mobile']);
	$email=str_replace("'","''",$_REQUEST['email']);
	$address=str_replace("'","''",$_REQUEST['address']);
	$sex=str_replace("'","''",$_REQUEST['sex']);
	$pwd=sha1($pwd1);
	$age=(int)$_REQUEST['age'];
	$Q="insert into person select max(pid)+1,'${name}','${pwd}','${mobile}','${sex}','${email}'
	,'${address}','','' from person ";
	$link = new PDO('mysql:dbname=h801;host=localhost;','h801','M7rtPka5#');
	$result=$link->query($Q);
	echo '<a href="index.html">按此回首頁</a>';
?>
</body>
</html>
