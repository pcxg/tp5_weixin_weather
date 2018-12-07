<?php
$lat = isset($_POST['lat'])? $_POST['lat'] : 0;
$lng = isset($_POST['lng'])? $_POST['lng'] : 0;
//	38.76623,116.43213
$baiduurl = "http://api.map.baidu.com/geocoder/v2/?location=".$lat.",".$lng."&coordtype=wgs84ll&output=json&pois=1&ak=1WriolOWerqERs2KNlEVtiBUmGjDFvlx";
$baidu_json = json_decode(file_get_contents($baiduurl));
$city = $baidu_json->result->addressComponent->city;

$codeurl = "http://188.131.154.107/index.php/city/".str_replace("市","",$city);
$code_json = json_decode(file_get_contents($codeurl));
if($code_json->code==200){
	$city_code = $code_json->data;
  	$wea_json = json_decode(file_get_contents("http://188.131.154.107/index.php/weather/".$city_code[0]));
    $info = $wea_json->data[0];
  	echo($info);
}







  
