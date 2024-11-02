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
        <?php include("html/nav.php") ?>
        <?php

            $path = "/var/www/html/dup/backup_wetterstation.sql";

            ini_set('display_errors', 1);
            ini_set('display_startup_errors', 1);
            error_reporting(E_ALL);

            exec("mysqldump --user={$ini['db_username']} --password={$ini['db_password']} --host={$ini['db_host']} {$ini['database']} --result-file={$path} 2>&1", $output);
            var_dump($output);
        ?>
    </body>
</html>