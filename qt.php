<?php
require('config.php');
require('dbconfig.php');
require('data.php');

$db_conn=db_connect("host=$DBHOST dbname=$DBNAME user=$DBUSER password=$DBPWD");
db_set_encoding($db_conn,'utf-8');

$chidsql="select max(aid) from data;";
$res1=db_exec($db_conn,$chidsql);
$AR=db_fetch_row($res1,$num);
        if ($num==0){
                for ($j=0;$j<count($AR);$j++){
                        $AR[$j]=trim($AR[$j]);
                        $aid=($AR[0]+1);
                }
        }
        echo $aid;

$time=date('Y.m.d H:i:s');
//$IP=$_SERVER['REMOTE_ADDR'] ;
$id=(int)$_REQUEST['id'];
$tem=(double)$_REQUEST['tem'];
$dirty=(double)$_REQUEST['dirty'];
$ph=(double)$_REQUEST['ph'];
$ec=(double)$_REQUEST['ec'];

$fp=fopen('tmp/recarps.txt','a+');
fwrite($fp,$_SERVER['QUERY_STRING']."\n");
fwrite($fp,"id=".$id."\n");
fwrite($fp,"tem=".$tem."\n");
fwrite($fp,"dirty=".$dirty."\n");
fwrite($fp,"ph=".$ph."\n");
fwrite($fp,"ec=".$ec."\n");

$Q="insert into data(id,aid,tem,dirty,ph,ec,time) values";
$Q=$Q."('$id','$aid','$tem','$dirty','$ph','$ec','$time')";
fwrite($fp,"Q=".$Q."\n");
fclose($fp);
$result=db_exec($db_conn,$Q);
 if (!$result)
    die("DataBase $Q exec fail!");
echo '1';
?>

