<?php
    $conn = connect_to_db($dbsrv, $dbuser, $passwd, $database);//Create Database Co0nnection

    $sql = "SELECT Wind FROM wetterdaten01 ORDER BY datetime DESC LIMIT 1";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $act_windrichtung = $row["Wind"];
        } else {
            die("No wind direction data found");
        }
?>