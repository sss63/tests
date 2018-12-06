<?php

$log = fopen("/var/www/test/test_brvdev/log/php.log","a");
fwrite($log, "[serv.php console out]".date(DATE_RFC822)."\n"); 
fwrite($log, "Country:".$_GET["country"].
            " Offset:".$_GET["offset"].
            " Page_len:".$_GET["page_len"]."\n"); 

$mysqli = new mysqli('localhost', 'brvdev', '123123', 'brvdev');
if ($mysqli->connect_error) {
    fwrite($log, ('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error));
}
$mysqli->set_charset("utf8");
    
$country = "%ия%";
$offset = 2;
$page_len = 6;
// Если передан параметр $country выполняем запрос по городам, 
if (isset($_GET["country"]))  {
    fwrite($log, "cities\n");

    $country = $_GET["country"];
    if (isset($_GET["offset"]))  $offset = $_GET["offset"]; 
    if (isset($_GET["page_len"]))  $page_len = $_GET["page_len"]; 
    if ($sql_st = $mysqli->prepare('SELECT
                                        CITYNAME
                                    FROM
                                        countries,
                                        cities
                                    WHERE
                                        (COUNTRYNAME LIKE ?) AND (countries.CODE = cities.CODE)
                                    LIMIT ? OFFSET ?' )) {
        $sql_st->bind_param("sii", $country, $page_len, $offset);
        $sql_st->execute();
        $sql_st->bind_result($cityname);
        while ($sql_st->fetch()) {
            $cities[] = $cityname; 
        }
        echo json_encode($cities, JSON_UNESCAPED_UNICODE+JSON_PRETTY_PRINT);
    }
// если нет - по странам     
} else {
    fwrite($log, "countries\n");
    if ($sql_st = $mysqli->prepare('SELECT 
                                        CODE,
                                        COUNTRYNAME
                                    FROM
                                        countries')) {

        $sql_st->execute();
        $sql_st->bind_result($code, $countryname);
        while ($sql_st->fetch()) {
            $countries["$code"] = $countryname;
        }
        echo json_encode($countries, JSON_UNESCAPED_UNICODE+JSON_PRETTY_PRINT);
    }  
}
$sql_st->close();
$mysqli->close();

fclose($log);

?>
