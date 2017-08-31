<?php
// Data
$members = array('소원', '예린', '은하', '유주', '신비', '엄지');
$albums = array('Season of Glass', 'Flower Bud', 'Snowflake', 'LOL');
 
// Create XML
$xml = new SimpleXMLElement('<girlgroup />');
 
// Generate elements
$xml->addChild('name', '여자친구');
$x_members = $xml->addChild('members');
$x_albums = $xml->addChild('albums');
 
// Array to elements
foreach ($members as $member)
    $x_members->addChild('member', $member);
 
foreach ($albums as $album)
    $x_albums->addChild('album', $album);

//Header('Content-Type: application/xml');
//print($xml->asXML());
 
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