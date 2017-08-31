<?php

include 'db_config.php';


//1. DB 연결
$connect = @mysql_connect($mysql_hostname.':'.$mysql_port, $mysql_username, $mysql_password); 

if(!$connect){
	echo '[연결실패] : '.mysql_error().'<br>'; 
	die('MySQL 서버에 연결할 수 없습니다.');
} 
//2. DB 선택
@mysql_select_db($mysql_database, $connect) or die('DB 선택 실패');

//3. 문자셋 지정
mysql_query(' SET NAMES '.$mysql_charset);

//4. 쿼리 생성
$query = 'UPDATE  tb_remote SET state = \'ok\' WHERE id ='.$rid;

//5. 쿼리 실행
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