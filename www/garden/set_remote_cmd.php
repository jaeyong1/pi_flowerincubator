<?php

include 'db_config.php';

$strcmd = $_POST["strcmd"];
//echo 'strcmd='.$strcmd.'<br>';

//1. DB ����
$connect = @mysql_connect($mysql_hostname.':'.$mysql_port, $mysql_username, $mysql_password); 

if(!$connect){
	echo '[�������] : '.mysql_error().'<br>'; 
	die('MySQL ������ ������ �� �����ϴ�.');
} 
//2. DB ����
@mysql_select_db($mysql_database, $connect) or die('DB ���� ����');

//3. ���ڼ� ����
mysql_query(' SET NAMES '.$mysql_charset);

//4. ���� ����
$query = '
	INSERT INTO  tb_remote (
	id ,
	tm ,
	command ,
	state
	)
	VALUES (
	NULL , NOW( ) ,  \''.$strcmd.'\',  \'waiting\'
	)';
	

//5. ���� ����
$result = mysql_query($query);

if ($result)
{
	//echo 'result ok';
	header("Location: remote.php"); //must be first print
}
else
{
	echo 'result failed';
}
?>