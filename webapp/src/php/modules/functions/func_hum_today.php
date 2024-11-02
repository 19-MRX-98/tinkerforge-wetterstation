<?php
function hum_today($db, $umrechnung_temp) {
    if ($db->connect_error) {
        die("Verbindung fehlgeschlagen: " . $db->connect_error);
    }

    $get_temp = "SELECT DATETIME, Feuchte as feuchte FROM wetterdaten01 WHERE date(datetime) = CURDATE()";
    $result = $db->query($get_temp);

    $feuchte = array();
    $zeit = array();

    while ($row = $result->fetch_assoc()) {
        $feuchte [] = round($row['feuchte'], 1);
        $zeit[] = date('H:i', strtotime($row['DATETIME']));
    }

    // Chart.js-Diagramm erstellen
    echo "<canvas id='HumChart'></canvas>";
    echo "<script>
        var ctx = document.getElementById('HumChart').getContext('2d');
        var chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: " . json_encode($zeit) . ",
                datasets: [{
                    label: 'Temperatur',
                    data: " . json_encode($feuchte) . ",
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
                            text: 'Luftfeuchtigkeit (%)'
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
hum_today($db, $umrechnung_temp);
?>