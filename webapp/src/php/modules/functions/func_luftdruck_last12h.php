<?php
    $db = connect_to_db($dbsrv, $dbuser, $passwd, $database);
    $module = check_airpressure_avail($airpressure_module);

    function luftdruck_last12h($module, $db, $ini) {
        if ($module == 1) {
            logs("Modul Wettervorhersage | Status => ON");
    
            $sql = "SELECT airpressure, datetime FROM airpressure WHERE datetime >= NOW() - INTERVAL 12 HOUR ORDER BY datetime ASC";
            $result = $db->query($sql);
            
            if ($result && $result->num_rows > 0) {
                $pressure_data = [];
                $labels = [];
                while ($row = $result->fetch_assoc()) {
                    $pressure_data[] = $row['airpressure'] / $ini['umrechnung_luftdruck'];
                    $labels[] = date('H:i', strtotime($row['datetime']));
                }
                return ['labels' => $labels, 'data' => $pressure_data];
            } else {
                logs("Keine Luftdruckdaten für die letzten 12 Stunden gefunden.");
                return null;
            }
        } else {
            logs("Modul Wettervorhersage | Status => OFF");
            return null;
        }
    }
    
    $luftdruck_daten = luftdruck_last12h($module, $db, $ini);
    
    // Schließen Sie die Datenbankverbindung
    $db->close();
    ?>
    <style>
        canvas {
            background-color: black; /* Setzt die Hintergrundfarbe auf Schwarz */
        }
    </style>
    <script>
        <?php if ($luftdruck_daten !== null): ?>
            const cta = document.getElementById('luftdruckChart').getContext('2d');
            const luftdruckChart = new Chart(cta, {
                type: 'line',
                data: {
                    labels: <?php echo json_encode($luftdruck_daten['labels']); ?>,
                    datasets: [{
                        label: 'Luftdruck (hPa)',
                        data: <?php echo json_encode($luftdruck_daten['data']); ?>,
                        borderColor: 'rgba(255, 255, 255, 1)',
                        backgroundColor: 'rgba(255, 255, 255, 0.1)',
                        borderWidth: 2,
                        pointBackgroundColor: 'rgba(255, 255, 255, 1)',
                        pointBorderColor: 'rgba(255, 255, 255, 1)',
                        pointHoverBackgroundColor: 'rgba(255, 255, 255, 1)',
                        pointHoverBorderColor: 'rgba(255, 255, 255, 1)'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        x: {
                            grid: {
                                color: 'rgba(255, 255, 255, 0.1)'
                            },
                            ticks: {
                                color: 'rgba(255, 255, 255, 0.8)'
                            }
                        },
                        y: {
                            grid: {
                                color: 'rgba(255, 255, 255, 0.1)'
                            },
                            ticks: {
                                color: 'rgba(255, 255, 255, 0.8)'
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            labels: {
                                color: 'rgba(255, 255, 255, 0.8)'
                            }
                        },
                        title: {
                            display: true,
                            text: 'Luftdruck der letzten 12 Stunden',
                            color: 'rgba(255, 255, 255, 1)'
                        }
                    }
                }
            });
        <?php else: ?>
        document.write('Keine Luftdruckdaten verfügbar.');
        <?php endif; ?>
    </script>