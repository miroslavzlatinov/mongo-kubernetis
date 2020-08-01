<!DOCTYPE html>
<html>
<head>
<style>

</style>
</head>
<body>

<form action="index.php" method="post">
Message: <input type="text" name="message"><br>
<input type="submit">

</form>

</body>
</html>

<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
date_default_timezone_set('Europe/Sofia');

    
    $host = 'mongo-host';
    if (!empty($_POST["message"])) {
    $connection = new MongoClient( "mongodb://".$host.":27017" );
    $db = $connection->selectDB('test');
    $collection = $db->selectCollection('messages');
    $collection->insert( array("message" => $_POST['message'], "datetime" => date("Y-m-d H:i:s"))) ;
    $_POST = array();
    $search = $collection->find();
    
    toTable($search);

    
} else {
    $connection = new MongoClient( "mongodb://".$host.":27017" );
    $db = $connection->selectDB('test');
    $collection = $db->selectCollection('messages');
    $search = $collection->find();
    toTable($search);
}

    function toTable($object){
       $array =  iterator_to_array($object);
       if (count($array) > 0){ 
       echo  "<table>";
       echo   "<thead>";
       echo     "<tr>";
       echo       "<th>".implode('</th><th>', array_keys(current($array)))."</th>";
       echo     "</tr>";
       echo   "</thead>";
       echo "<tbody>";
       foreach ($array as $row){
        array_map('htmlentities', $row);
      
        echo  "<tr>";
        echo   "<td>".implode('</td><td>', $row)."</td>";
        echo  "</tr>";
        }
        echo "</tbody>";
        echo "</table>";
       }
    }

  
 ?>