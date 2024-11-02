<?php
function temp_today($db, $umrechnung_temp) {
    if ($db->connect_error) {
        die("Verbindung fehlgeschlagen: " . $db->connect_error);
    }

    $get_temp = "SELECT DATETIME, temperatur/$umrechnung_temp as temp FROM wetterdaten01 WHERE date(datetime) = CURDATE()";
    $result = $db->query($get_temp);

    $temperatur = array();
    $zeit = array();

    while ($row = $result->fetch_assoc()) {
        $temperatur[] = round($row['temp'], 1);
        $zeit[] = date('H:i', strtotime($row['DATETIME']));
    }

    // Chart.js-Diagramm erstellen
    echo "<canvas id='tempChart'></canvas>";
   //echo "<script src='https://cdn.jsdelivr.net/npm/chart.js'></script>";
    echo "<script>
        var ctx = document.getElementById('tempChart').getContext('2d');
        var chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: " . json_encode($zeit) . ",
                datasets: [{
                    label: 'Temperatur',
                    data: " . json_encode($temperatur) . ",
                    borderColor: 'rgb(75, 192, 192)',
                    tension: 0.1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: false,
                        title: {
                            display: true,
                            text: 'Temperatur (°C)'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Uhrzeit'
                        }
                    }
                }
            }
        });
    </script>";
}

// Funktionsaufruf
temp_today($db, $umrechnung_temp);
?>