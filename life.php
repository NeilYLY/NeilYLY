<?php
$pwd=$_REQUEST['pwd'];
if ($pwd!='LeQpmRa4')
	die('0');
//$id=(int)$_REQUEST['id'];
$tem=(float)$_REQUEST['tem'];//溫度
$dirty=(float)$_REQUEST['dirty'];//混濁度
$ph=(float)$_REQUEST['ph'];//ph值
$ec=(float)$_REQUEST['ec'];//導電度
echo('arduino='.$tem.' '.$dirty);
$time=time();
$fp=fopen('tmp/rec.txt.new','a+');
fwrite($fp,"tem=$tem dirty=$dirty ph=$ph ec=$ec\n");
fclose($fp);

if (rename('tmp/rec.txt.new','tmp/rec.txt'))
	echo '1';
else echo '0';

$q=str_replace('LeQpmRa4','',$_SERVER['QUERY_STRING']);
$q=$q.'&ti='.$time;
$ret=join('',file('http://120.114.140.212/qt.php?'.$q));
if ($ret<=0)
{
    $fp=fopen('tmp/recarps.txt','a+');
    fwrite($fp,$q."\n");
	fclose($fp);
}
else if (is_file('tmp/recarps.txt'))
{
	rename('tmp/recarps.txt','tmp/recarps.txt.old');
	$item=file('tmp/recarps.txt.old');
	for ($i=0;$i<count($item);$i++)
	{
		$q=trim($item[$i]);
		$ret=join('',file('http://120.114.140.212/qt.php?'.$q));
		if ($ret<=0)
		{
    			$fp=fopen('tmp/recarps.txt','w');
    			fwrite($fp,$q."\n");
			fclose($fp);
		}
	}
	unlink('tmp/recarps.txt.old');
}
//echo "\n1";
?>
