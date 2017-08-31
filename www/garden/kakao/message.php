<?php
$password = '7311';	
include '../db_config.php';

/*
UPDATE  `jaeyong1`.`tb_remote_garden_now` SET  `fan` =  '0' WHERE  `tb_remote_garden_now`.`tm` =  '2017-08-25 14:14:17' AND  `tb_remote_garden_now`.`lamp` =1 AND  `tb_remote_garden_now`.`fan` =1 AND  `tb_remote_garden_now`.`humidity` =20 AND  `tb_remote_garden_now`.`temperature` =30 AND CONVERT(  `tb_remote_garden_now`.`reserved1` USING utf8 ) =  'a' AND CONVERT(  `tb_remote_garden_now`.`reserved2` USING utf8 ) =  'b' AND CONVERT(  `tb_remote_garden_now`.`reserved3` USING utf8 ) =  'c' LIMIT 1 ;
*/


//1. DB 연결
$connect = @mysql_connect($mysql_hostname.':'.$mysql_port, $mysql_username, $mysql_password); 

if(!$connect){
//	echo '[연결실패] : '.mysql_error().'<br>'; 
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
 

// Generate elements
/*
while($data=@mysql_fetch_row($result)){ 
	echo "tm : ".$data[0] ."<br>";
	echo "lamp : ".$data[1] ."<br>";
	echo "fan : ".$data[2] ."<br>";
	echo "humidity : ".$data[3] ."<br>";
	echo "temperature : ".$data[4] ."<br>";
}
*/


header('Content-Type: application/json; charset=utf-8;');
// 요청을 받아 저장
$data = json_decode(file_get_contents('php://input'), true);
 
// 받은 요청에서 content 항목 설정
$content = $data["content"];
 
// '시작하기' 버튼 처리
if( $content == "시작" )
{
echo <<< EOD
    {
        "message": {
            "text": "안녕^^;"
        }
    }
EOD;
}
// '도움말' 버튼 처리
else if( $content == "도움말" || $content == "help")
{
echo <<< EOD
    {
        "message": {
            "text": "지원하는 명령어는 다음과 같습니다. 시작:서버가 살아있는지 확인합니다. 상태:현재 화분의 상태를 알려줍니다. 사진:최근찍은 사진을 보여줍니다. 그밖에 불꺼, 불켜, 팬켜, 팬꺼 그밖에 문장에 대답을 합니다."
        }
    }    
EOD;
}

// '안녕'이란 단어가 포함되었을때 처리
else if( strpos($content, "안녕") !== false )
{
echo <<< EOD
    {
        "message": {
            "text": "안녕하세요~~ 화분입니다^^"
        }
    }    
EOD;
}

// '사진'이란 단어가 포함되었을때 처리
else if( strpos($content, "사진") !== false )
{
	$dir = '../pictures';
	$files = scandir($dir);
	rsort($files);
	//echo "latest :".$files[0]."\n";
	$picurl = "http://jaeyong1.cafe24.com/garden/pictures/".$files[0];
	$pictext = "가장 최근사진을 불러옵니다. ". $files[0];
echo <<< EOD
    {
        "message": {        
        	  "text": "$pictext" , 
            "photo" : {
            	"url": "$picurl" ,
      				"width": 640,
      				"height": 480
            }
          
        }
    }    
EOD;
}

// '상태'이란 단어가 포함되었을때 처리
else if( strpos($content, "상태") !== false )
{
	while($data=@mysql_fetch_row($result)){ 	
	$status =  "현재 화분상태는 습도는 ".$data[3]."%, 온도는 ".$data[4]."도 입니다..";
	if($data[1]=='1') $status = $status." 전등이 켜져있습니다.";
	if($data[2]=='1') $status = $status." 바람이 불고있습니다.";
	$status = $status." 정보는 ".$data[0]."에 업데이트 되었습니다.";
  }
echo <<< EOD
    {
        "message": {
            "text": "$status"
        }
    }    
EOD;
}

// '불켜'이란 단어가 포함되었을때 처리
else if( strpos($content, "불켜") !== false
 || strpos($content, "조명켜") !== false
 || strpos($content, "전등켜") !== false )
{
	//비밀번호 체크
   if( strpos($content, $password) !== false)
  {
	  //4. 쿼리 생성
		$query = '
		INSERT INTO  tb_remote (	id ,	tm ,	command ,	state	)
		VALUES (	NULL , NOW( ) ,  \'Lamp On\',  \'waiting\'	)';
		
		//5. 쿼리 실행
		$result = mysql_query($query);
	
		$status = "전등을 켜겠습니다.";  
	}
  else
  {
		$status = "비밀번호를 포함하여 보내주세요.";
  }
echo <<< EOD
    {
        "message": {
            "text": "$status"
        }
    }    
EOD;
}

// '불꺼'이란 단어가 포함되었을때 처리
else if( strpos($content, "불꺼") !== false
 || strpos($content, "조명꺼") !== false
 || strpos($content, "전등꺼") !== false )
{
  //비밀번호 체크
  if( strpos($content, $password) !== false)
  {
	  //4. 쿼리 생성
		$query = '
		INSERT INTO  tb_remote (	id ,	tm ,	command ,	state	)
		VALUES (	NULL , NOW( ) ,  \'Lamp Off\',  \'waiting\'	)';
	
		//5. 쿼리 실행
		$result = mysql_query($query);

		$status = "전등을 끄겠습니다.";
			}
  else
  {
		$status = "비밀번호를 포함하여 보내주세요.";
  }
echo <<< EOD
	    {
	        "message": {
	            "text": "$status"
	        }
	    }    
EOD;
}

// '팬켜'이란 단어가 포함되었을때 처리
else if( strpos($content, "팬켜") !== false
 || strpos($content, "선풍기켜") !== false
 || strpos($content, "바람불어") !== false
 || strpos($content, "바람을불어") !== false
 || strpos($content, "환풍기켜") !== false )
{
  //비밀번호 체크
  if( strpos($content, $password) !== false)
  {
	  //4. 쿼리 생성
		$query = '
		INSERT INTO  tb_remote (	id ,	tm ,	command ,	state	)
		VALUES (	NULL , NOW( ) ,  \'Fan On\',  \'waiting\'	)';
		
		//5. 쿼리 실행
		$result = mysql_query($query);
	
		$status = "바람을 불겠습니다.";
			}
  else
  {
		$status = "비밀번호를 포함하여 보내주세요.";
  }
echo <<< EOD
    {
        "message": {
            "text": "$status"
        }
    }    
EOD;
}
// '팬꺼'이란 단어가 포함되었을때 처리
else if( strpos($content, "팬꺼") !== false
 || strpos($content, "선풍기꺼") !== false
 || strpos($content, "바람불지") !== false
 || strpos($content, "바람없") !== false
 || strpos($content, "환풍기꺼") !== false )
{
	//비밀번호 체크
  if( strpos($content, $password) !== false)
  {
	  //4. 쿼리 생성
		$query = '
		INSERT INTO  tb_remote (	id ,	tm ,	command ,	state	)
		VALUES (	NULL , NOW( ) ,  \'Fan OFF\',  \'waiting\'	)';
		
		//5. 쿼리 실행
		$result = mysql_query($query);
	
		$status = "바람을 멈춥니다."; 
	}
  else
  {
		$status = "비밀번호를 포함하여 보내주세요.";
  }		
echo <<< EOD
    {
        "message": {
            "text": "$status"
        }
    }    
EOD;
}


// 그밖의 문장일때랜덤 
else
{
	$ran = mt_rand(1, 10);
	if ($ran==1) $outment ="앗!!! 음~~";
	else if ($ran==2) $outment ="아닐꺼예요..";
	else if ($ran==3) $outment ="오호! 그런가요~~";
	else if ($ran==4) $outment ="음~ 그렇군요..";
	else if ($ran==5) $outment ="알았어요ㅎㅎㅎ";
	else if ($ran==6) $outment ="쳇-_-;";
	else if ($ran==7) $outment ="오케이!!^^";
	else if ($ran==8) $outment ="음..음..";
	else if ($ran==9) $outment ="그건쫌아님요..";
	else $outment="그래요^^";
	
echo <<< EOD
    {
        "message": {
            "text": "$outment"
        }
    }    
EOD;
}
 
?>
