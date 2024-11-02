<?php
	//Parst .ini Datei in Variablen
	$ini = parse_ini_file("/var/www/html/src/conf/webapp.ini");
	$date = date("d.m.Y");
	//Zeitzone

	//Datenbank
	$database = $ini["database"];
	$dbsrv = $ini["db_host"];
	$dbuser= $ini["db_username"];
	$dbport= $ini["db_port"];
	$passwd = $ini["db_password"];
	//globale funktionen
	$global_func=$ini['global_function_file'];
	$header_path=$ini['header_path'];

	//logs
	$log_config_ok=$ini['log_config_ok'];
	$log_http_client_info=$ini['log_http_client_info'];
	$analog_path=$ini['analog_P'];

	//Zambretti
	$zambretti_forecast = $ini['zambretti_forecast'];
	$zambretti_forecast_html_output=$ini['zambretti_forecast_html_output'];
	$zambretti_calculation=$ini['zambretti_calculation'];

	//Wolken/Gewitter
	$cloudbase=$ini['cloudbase'];
	$theta_e_out=$ini['theta_e_out'];

	//Aktuelles Wetter
	$actual_weather=$ini['actual_weather'];
	$wind=$ini['wind'];
	$windchill=$ini['windchill'];
	$perticipation=$ini['perticipation'];

	//Bootstrap
	$bootstrap_min_js=$ini['bootstrap_min_js'];

	//Stats
	$stats_2022=$ini['stats_2022'];
	$stats_2023=$ini['stats_2023'];
	$stats_2024=$ini['stats_2024'];
	$stats_2025=$ini['stats_2025'];

	//Umrechnungen

	$umrechnung_temp=$ini['umrechnung_temp'];
	$umrechnung_niederschlag=$ini['umrechnung_niederschlag'];
	$umrechnung_luftdruck=$ini['umrechnung_luftdruck'];
	// Andere Variablen
	$message=''; //Logfile

	//Module
	$airpressure_module = $ini['airpressure_module'];
	$uv_module = $ini['uv_module'];
	$weatherforecast_module = $ini['weatherforecast_module'];

	//Creates Database Connection
	function connect_to_db($dbsrv, $dbuser, $passwd, $database) {
		$db = new mysqli($dbsrv, $dbuser, $passwd, $database);
		if ($db->connect_errno) {
			echo "Fehler " . $db->connect_errno . ": " . $db->connect_errno;
			exit;
		} else {
			return $db;
		}
		
	}
	connect_to_db($dbsrv, $dbuser, $passwd, $database);

	function logs($message,$error_level = 'INFO'){
			$logfile = "/var/www/html/src/logs/webapp.log";
			$date_time = date("Y-m-d H:i:s");
			$formatted_message = "[$date_time]-->[$error_level]-->[$message]\n";
			file_put_contents($logfile, $formatted_message, FILE_APPEND);
	}
	logs($message);

		//Checks The extra Modules
		//eg. UV, Airpressure

		function check_uv_module_avail($uv_module){
			if ($uv_module == "on") {
				return 1;
			}
			else
			{
				return 0;
			}
		}
		check_uv_module_avail($uv_module);

		function check_weather_forecast_avail($weatherforecast_module){
			if ($weatherforecast_module == "on") {
				return 1;
			}
			else
			{
				return 0;
			}
		}
		check_weather_forecast_avail($weatherforecast_module);

		function check_airpressure_avail($airpressure_module){
			if ($airpressure_module == "on") {
				return 1;
			}
			else
			{
				return 0;
			}
		}
		check_airpressure_avail($airpressure_module);

		function kelvin_to_celsius($kelvin) {
			return round($kelvin - 273.15, 1);
		}

		function tz_offset($ini){
			if($ini["utc_offset"] != 0){
				date_default_timezone_set($ini["tz"]);
			}
			else{
				return 0;
			}
		}	
		tz_offset($ini);

		function astrodate_sun_up($ini,$date){
			$date = date("d.m.Y");
            $sun_info=date_sun_info(strtotime($date),$ini["laengengrad"],$ini["breitengrad"]);
			$sonnenaufgang = $sun_info['sunrise'];
			$erg = date("H:i:s",$sonnenaufgang);
			return $erg;
		}
		astrodate_sun_up($ini,$date);

		function astrodate_sun_down($ini,$date){
			
            $sun_info=date_sun_info(strtotime($date),$ini["laengengrad"],$ini["breitengrad"]);
			$sonnenuntergang = $sun_info['sunset'];
			$erg = date("H:i:s",$sonnenuntergang);
			return $erg;
		}
		astrodate_sun_down($ini,$date);

		function sunUP_to_sunDOWN($ini,$date){
			$sun_info=date_sun_info(strtotime($date),$ini["laengengrad"],$ini["breitengrad"]);
            $tageslaenge = $sun_info['sunset'] - $sun_info['sunrise'];
            return date("H:i:s",$tageslaenge);
		}
		sunUP_to_sunDOWN($ini,$date);

		function sun_transit($ini,$date){
			$sun_info=date_sun_info(strtotime($date),$ini["laengengrad"],$ini["breitengrad"]);
			$sonnenhoechststand = $sun_info['transit'];
			return date("H:i:s",$sonnenhoechststand);
		}
		sun_transit($ini,$date);

		function civil_twilight_begin($ini,$date){
			$sun_info=date_sun_info(strtotime($date),$ini["laengengrad"],$ini["breitengrad"]);
			$civil_twilight_begin = $sun_info['civil_twilight_begin'];
			return date("H:i:s",$civil_twilight_begin);
		}
		civil_twilight_begin($ini,$date);

		function calc_day_and_night_lenght($ini,$date){
			$sun_info=date_sun_info(strtotime($date),$ini["laengengrad"],$ini["breitengrad"]);
			$tageslaenge_1 = $sun_info['sunset'] - $sun_info['sunrise'];

			$nachtlaenge = 86400 - $tageslaenge_1;
			return date("H:i:s",$nachtlaenge);
		}
		calc_day_and_night_lenght($ini,$date);
?>