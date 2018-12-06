<?php
//$log = fopen("/var/www/test/test_brvdev/log/php.log","a");
//fwrite($log, $_GET["city"]."\n"); 

$cities =  $_GET["city"];
//foreach($_GET["city"] as $city) fwrite($log, "\t".$city."\n"); 

foreach($cities as $cityname) {
  $data = file_get_contents("https://geocode-maps.yandex.ru/1.x/?apikey=785ebfb4-2d5f-45f7-b55d-690cb3d9f407&geocode=$cityname&format=json&results=1");
  list($long, $lat) = explode( " ", json_decode($data,true)["response"]["GeoObjectCollection"]["featureMember"][0]["GeoObject"]["Point"]["pos"] ); 
  $coords[] = array($lat, $long);
}
//$coords = explode( " ", json_decode($data,true)["response"]["GeoObjectCollection"]["featureMember"][0]["GeoObject"]["Point"]["pos"] ); 
  

echo json_encode($coords);

//fwrite($log, json_encode($coords)."\n"); 
//fclose($log);

?>