<?php

$user = 'root';
$password = '';

$database = '360synergydb';


$servername = 'localhost';
$mysqli = new mysqli(
  $servername,
  $user,
  $password,
  $database
);

if ($mysqli->connect_error) {
  die('Connect Error (' .
    $mysqli->connect_errno . ') ' .
    $mysqli->connect_error);
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0"> -->
  <link rel="stylesheet" href="main.css" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <!-- <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script> -->

  <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; minimum-scale=1.0;" />

  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;700&family=Outfit:wght@100;200;300;400;500;600;700;800;900&family=Roboto:ital,wght@1,900&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;500&family=Outfit:wght@100;200;300;400;500;600;700;800;900&family=Roboto:ital,wght@1,900&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;600&family=Outfit:wght@100;200;300;400;500;600;700;800;900&family=Roboto:ital,wght@1,900&display=swap" rel="stylesheet">
  <title>360Synergy</title>
  <script src="test.js"></script>
  
</head>

<body >
<div class="grid-container1">
    <div class="grid-item1a">
      <div class="gia">
        SMS In/Out Graph
      </div>
      <!-- <img src="Chart.png" class="img1"/> -->
      <canvas id="speedChart"></canvas>

    </div>
</div>
</body>
<script>
    var speedCanvas = document.getElementById("speedChart");


    var dataFirst = {
      label: "SMS In",
      data: ["", null, 700, 600, 20, 755, 40, 150, 50, 800, 500, 0, 200, 900],
      lineTension: 0,
      fill: false,
      borderColor: '#2DC12A',
      backgroundColor: '#2DC12A'
    };

    var dataSecond = {
      label: "SMS Out",
      data: [0, 0, 50, 280, 700, 0, 400, 300, 100, 600, 450, 100],
      lineTension: 0,
      fill: false,
      borderColor: '#FF3838',
      backgroundColor: '#FF3838'
    };
    var dataThird = {
      label: "Calls In",
      data: [300, 550, 75, 250, 620, 750, 300, 150, 300, 400],
      lineTension: 0,
      fill: false,
      borderColor: '#FFC738',
      backgroundColor: '#FFC738'
    };

    var dataFourth = {
      label: "Calls Out",
      data: [260, 300, 690, 300, 780, 200, 990, 500, 750, 800, 730],
      lineTension: 0,
      fill: false,
      borderColor: '#FF8B38',
      backgroundColor: '#FF8B38'
    };
    var speedData = {
      labels: ["Jan", "Feb", "Mar", "April", "May", "Jun", "Jul", "Aug", "Sept", "Oct", "Nov", "Dec"],
      datasets: [dataFirst, dataSecond, dataThird, dataFourth]
    };

    var chartOptions = {
      legend: {
        display: true,
        position: 'bottom',
        labels: {
          boxWidth: 40,
          usePointStyle: true,
          fontColor: 'black'
        }
      }
    };

    var lineChart = new Chart(speedCanvas, {
      type: 'line',
      data: speedData,
      options: chartOptions
    });
  </script>