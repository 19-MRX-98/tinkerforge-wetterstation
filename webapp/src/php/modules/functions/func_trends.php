<?php

function calculatePressureTrend($pressures) {
    if (count($pressures) < 2) {
        return "Nicht genügend Daten";
    }
    
    $firstPressure = end($pressures); // Das letzte Element ist der älteste Wert
    $lastPressure = $pressures[0];    // Das erste Element ist der neueste Wert
    $difference = $lastPressure - $firstPressure;
    
    if (abs($difference) < 1.0) {
        return "Stabil";
    } elseif ($difference >= 1.0 && $difference < 3.0) {
        return "Schwach steigend";
    } elseif ($difference >= 3.0) {
        return "Stark steigend";
    } elseif ($difference <= -1.0 && $difference > -3.0) {
        return "Schwach fallend";
    } else {
        return "Stark fallend";
    }
}

// Verbindung zur Datenbank herstellen
$conn = connect_to_db($dbsrv, $dbuser, $passwd, $database);

// SQL-Abfrage ausführen
$sql = "SELECT airpressure FROM $database.airpressure ORDER BY datetime DESC LIMIT 48";
$result = $conn->query($sql);

$pressures = [];

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        // Luftdruck umrechnen und zum Array hinzufügen
        $pressure = $row["airpressure"] / $ini["umrechnung_luftdruck"];
        $pressures[] = $pressure;
    }
    
    // Luftdrucktrend berechnen
    $trend_12h = calculatePressureTrend($pressures);

} else {
    echo "Keine Daten verfügbar";
}

// Verbindung schließen
$conn->close();
?>