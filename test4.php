<!DOCTYPE HTML>
<html>
<head>
    <meta charset="UTF-8"/>
	<meta http-equiv="content-type" content="text/html" />
	<meta name="Sergei Osintsev" content="test" />
	<title>test4</title>
    <script src='js/jquery-3.3.1.js'></script>
    <script src='js/script41.js'></script>
</head>

<body>
<br/>
<input id="country" name="country" type="text"/>
<button id="but">Поиск</button>
<?php
    $mysqli = new mysqli('localhost', 'brvdev', '123123', 'brvdev');
    if ($mysqli->connect_error) {
        die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
    }
    $mysqli->set_charset("utf8");
    $sql = "SELECT * FROM `countries`, `cities` where countries.code = cities.code";
    $res = $mysqli->query($sql);

    foreach($res as $row) {
        $countries[$row["CODE"]] = $row["COUNTRYNAME"];
        $cities[$row["CODE"]][] = $row["CITYNAME"]; 
    } 


    foreach($cities as $country_code => $cities_of_country) {
        echo "<div>";
        foreach($cities_of_country as $key => $city) {
            echo "<div class='country country$countries[$country_code]' style='display: none'>$city</div>";
        }           
        echo "</div>";
    }
?>    
<div id="pager" style="display: none"><span id="prev">Prev page</span> | <span id="next">Next page</span></div>



</body>
</html>