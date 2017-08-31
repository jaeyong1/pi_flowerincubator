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
  where state = \'waiting\'
  ORDER BY tb_remote.id ASC
  limit 0,1
';

//5. 쿼리 실행
$result = mysql_query($query);
 
// Create XML
$xml = new SimpleXMLElement('<feed />'); #for feedparser in python
$cnt = 0;
// Generate elements
while($data=@mysql_fetch_row($result)){ 
	$xml->addChild('rid', $data[0]);
  $xml->addChild('timestamp', $data[1]);
  $xml->addChild('command', $data[2]);
  $xml->addChild('state', $data[3]);
  $cnt = $cnt+1;
 } 
$xml->addChild('hasdata', $cnt); 
//HANGUL
// Print
$dom = new DOMDocument();
$dom->loadXML($xml->asXML());
$dom->preserveWhiteSpace = false;
$dom->formatOutput = true;
$dom->encoding = 'UTF-8';
$formattedXML = $dom->saveXML();
 Header('Content-Type: application/xml');
print($formattedXML);
 
?>