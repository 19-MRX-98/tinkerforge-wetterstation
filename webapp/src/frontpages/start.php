<?php
		require_once("/var/www/html/src/php/globals/global_functions.php");
		require_once("$global_func");
		require_once("$zambretti_forecast");
		$ld_check=check_airpressure_avail($airpressure_module);
		$forecast_check = check_weather_forecast_avail($weatherforecast_module);
		$uv_mod_check = check_uv_module_avail($uv_module);

?>

<style>
    img{
        width: 36px;
        height: 36px;
        margin-left: 8px;
        padding: 3px;
        color: white;
    }
	.container-fluid {
		margin-top: 1%;
		border-radius: 2px;
		padding: 0.5%;
	}
	.alert{
		padding: 1%;
	}

</style>
<!DOCTYPE html>
<html lang="de" data-bs-theme="<?php echo $ini['data-bs-theme']; ?>">
    <head>
        <meta charset="<?php echo $ini['charset']; ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="<?php echo $ini['bootstrap_min_path']; ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo $ini['bootstrap_main_path']; ?>">
		<link rel="stylesheet" type="text/css" href="<?php echo $ini['chartjs_css']; ?>">
        <script src="<?php echo $bootstrap_min_js ?>" async></script>
		<script src="src/chartjs_4.4/dist/chart.umd.js"></script>
		<script src="src/chartjs_4.4/dist/helpers.js"></script>
        <title>
                <?php echo $ini["wsname"];?>
        </title><!--Put your Weatherstation's Name in the Configurations PHP-->
        <?php include("$header_path");?>
    </head>
    <body>
		<div class="container-fluid bg-secondary text-white">
		<caption><h1><span class="badge bg-dark" style="margin-top:1%">Astronomische Wetterdaten</span></h1></caption>
			<div class = "row">
				<div class='col-sm-3'>
					<div class='card text-center'>
						<div class='card-body'>
							<h5 class='card-title'><img src="<?php echo $ini['sun_up']; ?>" alt="Sunrise Icon">Sonnenaufgang</h5><hr>
							<p class='card-text'>
								<?php echo $sun_up=astrodate_sun_up($ini,$date)." Uhr"; ?>
							</p>
						</div>
					</div>
				</div>
				<div class='col-sm-3'>
					<div class='card text-center'>
						<div class='card-body'>
							<h5 class='card-title'><img src="<?php echo $ini['sun_down']; ?>" alt="Sunrise Icon">Sonnenuntergang</h5><hr>
							<p class='card-text'>
								<?php echo $sun_down=astrodate_sun_down($ini,$date) ." Uhr"; ?>
							</p>
						</div>
					</div>
				</div>
				<div class='col-sm-3'>
					<div class='card text-center'>
						<div class='card-body'>
							<h5 class='card-title'>Tageslänge</h5><hr>
							<p class='card-text'>
								<?php echo sunUP_to_sunDOWN($ini,$date) ." Stunden";?>
							</p>
						</div>
					</div>
				</div>
				<div class='col-sm-3'>
					<div class='card text-center'>
						<div class='card-body'>
							<h5 class='card-title'></img>Nachtlänge</h5><hr>
							<p class='card-text'>
								<?php  echo calc_day_and_night_lenght($ini,$date) ." Stunden"; ?>
							</p>
						</div>
					</div>
					
				</div>
				<div class='col-sm-3'>
					<div class='card text-center'>
						<div class='card-body'>
							<h5 class='card-title'>Weitere Astronomische Daten:</h5><hr>
							<p class='card-text'>
								<?php  echo "Sonnenhöchststand: ".sun_transit($ini,$date) ." Uhr<br>"; ?>
								<?php  echo "Beginn der bürgerlichen Morgendämmerung: ".civil_twilight_begin($ini,$date) ." Uhr"; ?>
							</p>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<div class="container-fluid bg-secondary text-white">
		<div class="row">
				<div class="col-md-6">
					<div class="p-3 text-white">
							<div class="container-fluid">
							<caption><h1><span class="badge bg-dark" style="margin-top:-2%">Wettervorhersage</span></h1></caption>
								<p>
									<div class="chart-container">
										<?php
											include("$zambretti_calculation");
										?>
									</div>
								</p>
								<p>
								<caption><h1><span class="badge bg-dark">Luftdruckverlauf der letzten 12 Stunden</span></h1></caption>
									<div class="chart-container">
									<?php 
												if($ld_check == 1){
													echo "<canvas id='luftdruckChart'>";
														include("src/php/modules/functions/func_luftdruck_last12h.php");
													echo "</canvas>";
												}
												else{
													echo "
													<div class='alert alert-warning alert-dismissible fade show' role='alert'>
														<strong>Das Luftdruckmodul ist nicht aktiv. Bitte aktivieren! Wusstest du: Mit einem Klick auf das X verschwindet diese Meldung!</strong> 
														<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
													</div>";
												}
											?>
									</div>
								</p>
							</div>
							<caption><h1><span class="badge bg-dark">5 Tages Vorhersage</span></h1></caption>
							<div class="chart-container">
								<canvas id="weatherChart">
								<?php include("src/php/modules/functions/func_wettervorhersage.php"); ?>
								</canvas>
							</div>
						</div>
					</div>
				<div class="col-md-6">
					<div class="p-3 bg-secondary text-white">
						<caption><h1><span class="badge bg-dark" style="margin-top:-2%">Gewitterpotential der Luftmasse</span></h1></caption>
						<?php
							include("$theta_e_out");
						?>
						<?php
							include("$cloudbase");
						?>
					</div>
				</div>
			</div>
		</div>

		<div class="container-fluid bg-secondary text-white">
			<center><caption><h1><span class="badge bg-dark">Aktuelles Wetter</span></h1></caption></center>
				<div class = "row">
					<?php require_once($actual_weather); ?>
					<div class='col-sm-6'>
						<div class='card text-center'>
							<div class='card-body'>
								<h5 class='card-title'>Windrichtung</h5><hr>
								<p class='card-text'><?php require_once("$wind")?></p>
							</div>
						</div>
					</div>
					<div class='col-sm-6'>
						<div class='card text-center'>
							<div class='card-body'>
								<h5 class='card-title'>Windchill</h5><hr>
								<p class='card-text'><img src = 'src/pictures/icons8/icons8-windchill-96.png'></img><?php require_once("$windchill")?></p>
							</div>
						</div>
					</div>
					<div class='col-12'>
						<div class='card text-center'>
							<div class='card-body'>
								<h5 class='card-title'>Niederschlag 1h</h5><hr>
								<p class='card-text'><img src = 'src/pictures/icons8/icons8-raining-60.png'></img><?php require_once("$perticipation")?></p>
							</div>
						</div>
					</div>
				</div>
		</div>
    </body>
<html>