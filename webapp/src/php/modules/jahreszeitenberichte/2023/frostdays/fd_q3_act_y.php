<?php
    $db = new mysqli($dbsrv,$dbuser,$passwd,$database);
    if($db->connect_errno)
            {
                echo "Keine Verbindung m&ooml;glich! Bitte kontaktieren Sie den Administrator!\n";
                echo "Fehler".$db->connect_errno.":".$db->connect_errno; exit;
            }
            else
            {
            //$db->set_charset("utf-8");
            $get_avg_q1 = "SELECT COUNT(*) AS Frosttage
            FROM (
                SELECT DATE(datetime) AS Tag, MIN(Temperatur) AS Tagestiefsttemperatur
                FROM wetterdaten2023 PARTITION (p_wetterdaten_23_7,p_wetterdaten_23_8,p_wetterdaten_23_9)
                GROUP BY DATE(datetime)
                HAVING MIN(Temperatur) < 0
            ) AS Tagestiefstwerte";
            $avg_q1 = $db->query($get_avg_q1);
            while($data = $avg_q1->fetch_array())
                {
                    if($data[0] == 0){
                        echo "-";
                    }
                    else{
                        echo round($data[0],2);
                    }
                }
            }
            mysqli_close($db);
            #/umrechnung_wind_spitzen1*umrechnung_wind_spitzen2
?>