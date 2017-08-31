<?php

include 'db_config.php';

/*
UPDATE  `jaeyong1`.`tb_remote_garden_now` SET  `fan` =  '0' WHERE  `tb_remote_garden_now`.`tm` =  '2017-08-25 14:14:17' AND  `tb_remote_garden_now`.`lamp` =1 AND  `tb_remote_garden_now`.`fan` =1 AND  `tb_remote_garden_now`.`humidity` =20 AND  `tb_remote_garden_now`.`temperature` =30 AND CONVERT(  `tb_remote_garden_now`.`reserved1` USING utf8 ) =  'a' AND CONVERT(  `tb_remote_garden_now`.`reserved2` USING utf8 ) =  'b' AND CONVERT(  `tb_remote_garden_now`.`reserved3` USING utf8 ) =  'c' LIMIT 1 ;
*/


//1. DB 연결
$connect = @mysql_connect($mysql_hostname.':'.$mysql_port, $mysql_username, $mysql_password); 

if(!$connect){
	echo '[연결실패] : '.mysql_error().'<br>'; 
	die('MySQL 서버에 연결할 수 없습니다.');
} else {
	//echo '[연결성공]<br>';
}
//2. DB 선택
@mysql_select_db($mysql_database, $connect) or die('DB 선택 실패');

//3. 문자셋 지정
mysql_query(' SET NAMES '.$mysql_charset);

//4. 쿼리 생성
$query = 'SELECT * 
FROM  `tb_remote_garden_now` 
LIMIT 0 , 30
';

//5. 쿼리 실행
$result = mysql_query($query);
 
 
echo "<h1>get DB</h1> <br>";
// Generate elements
while($data=@mysql_fetch_row($result)){ 
	echo "tm : ".$data[0] ."<br>";
	echo "lamp : ".$data[1] ."<br>";
	echo "fan : ".$data[2] ."<br>";
	echo "humidity : ".$data[3] ."<br>";
	echo "temperature : ".$data[4] ."<br>";
}
?>