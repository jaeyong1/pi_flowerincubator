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
  where state = \'waiting\'
  ORDER BY tb_remote.id ASC
  limit 0,1
';

//5. ���� ����
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