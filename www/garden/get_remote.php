<?php

include 'db_config.php';

//1. DB ����
$connect = @mysql_connect($mysql_hostname.':'.$mysql_port, $mysql_username, $mysql_password); 

if(!$connect){
	echo '[�������] : '.mysql_error().'<br>'; 
	die('MySQL ������ ������ �� �����ϴ�.');
} else {
	//echo '[���Ἲ��]<br>';
}
//2. DB ����
@mysql_select_db($mysql_database, $connect) or die('DB ���� ����');

//3. ���ڼ� ����
mysql_query(' SET NAMES '.$mysql_charset);


//4. ���� ����
$query = 'SELECT * FROM
  tb_remote
  ORDER BY tb_remote.id DESC
  limit 0,10
';

//5. ���� ����
$result = mysql_query($query);

echo "<h1>Latest 10 commands</h1> <br>";
echo "<table border>";

// �Ӹ��� ���
echo "<tr>"; 
while($field=@mysql_fetch_field ($result)){ 
echo "<th>"; 
//print_r($field);
 echo $field->name;
 echo "</th>"; 
} 
echo "</tr>";


// ������ ��� 
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
//6. ���� ����
mysql_close($connect);