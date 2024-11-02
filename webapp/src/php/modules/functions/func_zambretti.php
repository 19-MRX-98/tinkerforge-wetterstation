<?php
    require_once("src/php/modules/querys/select_act_airpressure.php");
    require_once("src/php/modules/querys/select_act_wind_direction.php");
    require_once("func_trends.php");

    $month = date('n');
    $hemisphere = $ini["Hemisphere"];
    $pressure_min = $ini['minimaldruck'];
    $pressure_max = $ini['maximaldruck'];

    function windnumbers_to_array($act_windrichtung){
        $wind_directions = [
            "0" => "N", "1" => "NNE", "2" => "NE", "3" => "ENE",
            "4" => "E", "5" => "ESE", "6" => "SE", "7" => "SSE",
            "8" => "S", "9" => "SSW", "10" => "SW", "11" => "WSW",
            "12" => "W", "13" => "WNW", "14" => "NW", "15" => "NNW"
        ];
        return isset($wind_directions[$act_windrichtung]) ? $wind_directions[$act_windrichtung] : "Unbekannt";
    }
    
    class ZambrettiForecaster {
        private $forecasts = [
            "Beständiges Hochdruckwetter.",
            "Schönes Wetter.",
            "Wird schön",
            "Schön, wird wechselhaft",
            "Schön, Regenschauer möglich",
            "Ziemlich gut, verbessert sich",
            "Ziemlich gut, möglicherweise Schauer",
            "Ziemlich gut, frühe Schauer",
            "Aufheiternd, bald besser",
            "Ziemlich gut, möglicherweise Regen",
            "Wechselhaft, verbessert sich",
            "Ziemlich gut, Schauer möglich",
            "Unbeständig, wahrscheinlich verbessert sich",
            "Wechselhaft, kurze sonnige Abschnitte",
            "Wechselhaft, möglicherweise Regen",
            "Unbeständig, kurze sonnige Abschnitte",
            "Gelegentliche Schauer, wechselhaft",
            "Schauer, wird unbeständig",
            "Häufige Schauer, keine Besserung",
            "Unbeständig, möglicherweise verbessernd",
            "Veränderlich, viel Regen.",
            "Regen, wird sehr unbeständig",
            "Regen, wird schlechter",
            "Regen, wird stürmisch",
            "Stürmisch, möglicherweise verbessernd",
            "Stürmisch, viel Regen"
        ];
    
        private $rise_options = [25,25,25,24,24,19,16,12,11,9,8,6,5,2,1,1,0,0,0,0,0,0];
        private $steady_options = [25,25,25,25,25,25,23,23,22,18,15,13,10,4,1,1,0,0,0,0,0,0];
        private $fall_options = [25,25,25,25,25,25,25,25,23,23,21,20,17,14,7,3,1,1,1,0,0,0];
    
        public function getForecast($pressure, $trend, $windrichtung, $month) {
            $z = $this->calculateZ($pressure, $month);
            $option = $this->getOption($z);
            
            switch ($trend) {
                case 'rising':
                    $forecast = $this->forecasts[$this->rise_options[$option]];
                    break;
                case 'falling':
                    $forecast = $this->forecasts[$this->fall_options[$option]];
                    break;
                default: // steady
                    $forecast = $this->forecasts[$this->steady_options[$option]];
            }
    
            $forecast = $this->adjustForWind($forecast, $windrichtung);
            return $this->adjustForSeason($forecast, $month);
        }
    
        private function calculateZ($pressure, $month) {
            $p = $pressure;
            if ($month >= 3 && $month <= 5) { // Frühling
                return floor(($p - 500) / 5.0);
            } elseif ($month >= 6 && $month <= 8) { // Sommer
                return floor(($p - 500) / 5.22);
            } elseif ($month >= 9 && $month <= 11) { // Herbst
                return floor(($p - 500) / 4.9);
            } else { // Winter
                return floor(($p - 500) / 4.77);
            }
        }
    
        private function getOption($z) {
            return max(0, min(21, $z));
        }
    
        private function adjustForWind($forecast, $windrichtung) {
            $windEffects = [
                'N' => 'kälter und trockener',
                'NE' => 'kälter und trockener',
                'E' => 'trockener, im Sommer wärmer, im Winter kälter',
                'SE' => 'wärmer und feuchter',
                'S' => 'wärmer und feuchter',
                'SW' => 'wärmer und feuchter',
                'W' => 'milder und feuchter',
                'NW' => 'kühler und feuchter'
            ];
    
            $direction = substr($windrichtung, 0, 2); // Nimm die ersten zwei Buchstaben
            if (isset($windEffects[$direction])) {
                return $forecast . " (" . $windEffects[$direction] . " durch " . $windrichtung . "-Wind)";
            }
            return $forecast;
        }
    
        private function adjustForSeason($forecast, $month) {
            $season = $this->getSeason($month);
            switch ($season) {
                case 'Frühling':
                    return $forecast . " Typisches Frühlingswetter mit wechselhaften Bedingungen möglich.";
                case 'Sommer':
                    return $forecast . " Bei hohen Temperaturen auf ausreichende Flüssigkeitszufuhr achten.";
                case 'Herbst':
                    return $forecast . " Herbstliche Temperaturschwankungen und Nebel sind möglich. Bei längeren Hochdruckphasen ist eine KALTE Inversionswetterlage möglich. 
                    Bei solchen Lagen droht Auskühlungsgefahr und damit Frost oder überfrierende Nässe";
                case 'Winter':
                    return $forecast . " Bei Minustemperaturen auf Glättegefahr achten.";
                default:
                    return $forecast;
            }
        }
    
        private function getSeason($month) {
            if ($month >= 3 && $month <= 5) return 'Frühling';
            if ($month >= 6 && $month <= 8) return 'Sommer';
            if ($month >= 9 && $month <= 11) return 'Herbst';
            return 'Winter';
        }
    }

?>