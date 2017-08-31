<?php

include 'db_config.php';

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
$query = 'SELECT * FROM
  tb_remote
  ORDER BY tb_remote.id DESC
  limit 0,10
';

//5. 쿼리 실행
$result = mysql_query($query);

echo "<h1>Latest 10 commands</h1> <br>";
echo "<table border>";

// 머릿글 출력
echo "<tr>"; 
while($field=@mysql_fetch_field ($result)){ 
echo "<th>"; 
//print_r($field);
 echo $field->name;
 echo "</th>"; 
} 
echo "</tr>";


// 데이터 출력 
while($data=@mysql_fetch_row($result)){
 echo "<tr>"; 
 for($i=0;$i<(count($data));$i++){
	 echo "<td>"; 
	 echo $data[$i]; 
	 echo "</td>"; 
 } 
echo "</tr>"; 
} 

echo "</table>";
//6. 연결 종료
mysql_close($connect);