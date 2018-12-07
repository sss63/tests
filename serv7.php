<?php
$log = fopen("log/php.log","a");
fwrite($log, "[serv7.php] ".date(DATE_RFC822)."\n"); 

require 'conf.php'; 

fwrite($log, DB_USER."\n"); 


$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($mysqli->connect_error) {
    fwrite($log, ('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error));
}
$mysqli->set_charset("utf8");
    
// Если передан параметр $country выполняем запрос по городам, 
$country = "%ия%";
$offset = 0;
$page_len = 16;

if (isset($_GET["country"])) $country = "%".$_GET["country"]."%";
if (isset($_GET["offset"]))  $offset = $_GET["offset"]; 
if (isset($_GET["page_len"]))  $page_len = $_GET["page_len"]+1; 
if ($sql_st = $mysqli->prepare('SELECT
                                    CITYNAME
                                FROM
                                    countries,
                                        cities
                                WHERE
                                    (COUNTRYNAME LIKE ?) AND (countries.CODE = cities.CODE)
                                LIMIT ? 
                                OFFSET ?' )) {
    $sql_st->bind_param("sii", $country, $page_len, $offset);
    $sql_st->execute();
    $sql_st->bind_result($cityname);
    while ($sql_st->fetch()) {
        $cities[] = $cityname; 
    }
    echo json_encode($cities, JSON_UNESCAPED_UNICODE+JSON_PRETTY_PRINT);
}
$sql_st->close();
$mysqli->close();

fclose($log);

?>
