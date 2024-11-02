<?php

    // Verwendungsbeispiel:
    $forecaster = new ZambrettiForecaster();

    // Beispielparameter
    $pressure_act = $pressure; // Luftdruck in hPa
    $trend = $trend_12h; // 'rising', 'falling', oder 'steady'
    $windrichtung = windnumbers_to_array($act_windrichtung);
    $month = $month; // Monat (1-12)
    
    $forecast = $forecaster->getForecast($pressure, $trend, $windrichtung, $month);

    echo "Zambretti-Vorhersage: " . $forecast;
?>