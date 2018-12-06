<!DOCTYPE HTML>
<html>
<head>
    <meta charset="UTF-8"/>
	<meta http-equiv="content-type" content="text/html" />
	<meta name="Sergei Osintsev" content="test" />
	<title>test1</title>
</head>

<body>
Список:<br/>
<?php
    $mysqli = new mysqli('localhost', 'brvdev', '123123', 'brvdev');
    if ($mysqli->connect_error) {
        die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
    }
    $mysqli->set_charset("utf8");
    $sql = "select * from countries";
    $result = $mysqli->query($sql);
    
    foreach($result as $row) {
        echo $row["COUNTRYNAME"];
        echo "<br/>";        
    } 

?> 

</body>
</html>