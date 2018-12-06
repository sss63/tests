<!DOCTYPE HTML>
<html>
<head>
    <meta charset="UTF-8"/>
	<meta http-equiv="content-type" content="text/html" />
	<meta name="Sergei Osintsev" content="test" />
	<title>test2</title>
    <script src='js/jquery-3.3.1.js'></script>
    <script src='js/script2.js'></script>
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
//print_r($cities);
    print "<option></option>";
    foreach($countries as $key => $country) {
        print "<option value=$key>$country</option>";
    } 
    echo '</select>';

    foreach($cities as $key => $cities) {
        echo "<div id=country$key class='cities' style='display: none'>";
        foreach($cities as $city) {
            echo "<div>$city</div>";
        }           
        echo "</div>";
    }
?>    


</body>
</html>