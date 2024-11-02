<?php
    require_once("php/globals/global_functions.php");
?>
<!DOCTYPE html>
<html lang="de" data-bs-theme="auto">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
        <link rel="stylesheet" type="text/css" href="css/sidebar.css">
        <script src="chartjs_4.4/dist/chart.umd.js"></script>
        <script src="js/bootstrap.bundle.min.js" async></script>
        <script src="js/sidebar.js" async></script>
        <script src="js/colormode.js" async></script>
        <script src="js/darkmode.js" async></script>
        <title>Datenbankupdate</title>   
    </head>
    <body>
        <?php include("html/nav.php"); echo  __File__;?>
            <center><h1><span class="badge text-bg-info">Vorbereitende Schritte für Datenbankupdate</span></h1></center><br>
            
            <div class="row">
                <div class="col-sm-6 mb-3 mb-sm-0">
                    <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Datenbankbackup</h5>
                        <p class="card-text">Das Datenbankbackup verhindert Datenverlust und<br>
                         sollte auf jeden Fall ausgeführt werden.
                            Status der Datenbanksicherung:                 
                        </p>
                        <a href="database_update/dump" class="btn btn-primary">Starte Datenbankbackup</a>
                    </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Comserver ausschalten</h5>
                        <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                        <a href="#" class="btn btn-primary">Go somewhere</a>
                    </div>
                    </div>
                </div>
            </div>
            <br>
            <center><a class="btn btn-primary" href="#" role="button">Starte Update</a></center>
    </body>
</html>