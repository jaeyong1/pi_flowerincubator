<?php

include 'db_config.php';


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
$query = 'UPDATE  tb_remote SET state = \'ok\' WHERE id ='.$rid;

//5. ���� ����
$result = mysql_query($query);

// print
//echo 'query='.$query.'<br>';
if ($result)
{
	echo 'result ok';
}
else
{
	echo 'result failed';
}
?>