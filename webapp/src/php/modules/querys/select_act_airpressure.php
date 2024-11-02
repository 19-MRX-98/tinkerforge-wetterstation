<?php
    $conn =  connect_to_db($dbsrv, $dbuser, $passwd, $database); //Create Database Connection
    $sql1 = "SELECT airpressure FROM $database.airpressure ORDER BY datetime DESC LIMIT 24";
    $result = $conn->query($sql1);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $pressure_act= $row["airpressure"]/$ini["umrechnung_luftdruck"];    
        }
    } 
    else {
        echo "0 results";
    }
    $conn->close();

?>