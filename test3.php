<!DOCTYPE HTML>
<html>
<head>
    <meta charset="UTF-8"/>
	<meta http-equiv="content-type" content="text/html" />
	<meta name="Sergei Osintsev" content="test" />
	<title>test3</title>
    <script src='js/jquery-3.3.1.js'></script>
    <script src='js/script3.js'></script>
</head>

<body>
Список:<br/>
<?php
    $mysqli = new mysqli('localhost', 'brvdev', '123123', 'brvdev');
    if ($mysqli->connect_error) {
        die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
    }
    $mysqli->set_charset("utf8");
    $sql = "SELECT * FROM `countries`, `cities` where countries.code = cities.code";
    $res = $mysqli->query($sql);
?>
<?php     
    echo '<select id="country" name="country">';
    foreach($res as $row) {
        $countries[$row["CODE"]] = $row["COUNTRYNAME"];
        $cities[$row["CODE"]][] = $row["CITYNAME"]; 
    } 
    print "<option></option>";
    foreach($countries as $key => $country) {
        print "<option value=$key>$country</option>";
    } 
    echo '</select>';

    foreach($cities as $country_code => $cities_of_country) {
        echo "<div>";
        foreach($cities_of_country as $key => $city) {
            echo "<div class='country country$country_code' style='display: none'>$city</div>";
        }           
        echo "</div>";
    }
?>    
<div id="pager" style="display: none"><span id="prev">Prev page</span> | <span id="next">Next page</span></div>

</body>
</html>