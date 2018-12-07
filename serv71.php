<?php
$log = fopen("log/php.log","a");
fwrite($log, "[serv71.php] ".date(DATE_RFC822)."\n"); 

require 'conf.php';

$dsn = 'mysql:host='.DB_HOST.';dbname='.DB_NAME;
$option = array(
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
);
try {
    $dbh = new PDO($dsn, DB_USER, DB_PASS, $option);
} catch (PDOException $e) {
    fwrite($log, 'Connction error: '.$e->getMessage());
}
$country = "%ия%";
$offset = 0;
$page_len = 17;

// Если передан параметр $country выполняем запрос по городам, 
if (isset($_GET["country"])) $country = "%".$_GET["country"]."%";
if (isset($_GET["offset"]))  $offset = +$_GET["offset"]; 
if (isset($_GET["page_len"]))  $page_len = +$_GET["page_len"]+1; 

fwrite($log, $country." ".($offset+1-1)." ".($page_len+1-1)."\n");

$sql_st = $dbh->prepare("SELECT
                            CITYNAME
                        FROM
                            countries,
                            cities
                        WHERE
                            (COUNTRYNAME LIKE :country) AND (countries.CODE = cities.CODE)
                        LIMIT :page_len 
                        OFFSET :offset");

$sql_st->bindParam(':country', $country, PDO::PARAM_STR);
$sql_st->bindParam(':page_len', $page_len, PDO::PARAM_INT);
$sql_st->bindParam(':offset', $offset, PDO::PARAM_INT);
$sql_st->execute();
$cities = $sql_st->fetchAll(PDO::FETCH_COLUMN, 0);

fwrite($log, count($cities)."\n");

echo json_encode($cities, JSON_UNESCAPED_UNICODE+JSON_PRETTY_PRINT);

$sql_st = NULL;
$dbh = NULL;
fclose($log);
?>
