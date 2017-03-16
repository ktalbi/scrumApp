<!DOCTYPE html>

<html>
<head>
    <meta charset="utf-8">
<link rel="stylesheet" href="../css/bootstrap/dataTables.bootstrap.min.css"/>
<link rel="stylesheet" href="../css/bootstrap/bootstrap.css" />
<link rel="stylesheet" href="../css/style.css" />
<link rel="shortcut icon" href="favicon.ico"> <!-- fix the favicon error 404 -->

<title>Sprint</title>
</head>

<body>

    <!-- Navbar Twitter Bootstrap -->

<ul class="nav nav-tabs nav-justified">
  <li class="active"><a href="index">Créer Sprint</a></li>
  <li><a href="page2.php">Attribution Heures</a></li>
  <li><a href="page3.php">Heures Descendues</a></li>
  <li><a href="page4.php">Burndownchart</a></li>
  <li><a href="../login/logout.php">Déconnexion</a></li>
</ul>

<!-- Link to db PDO connect -->

<?php
include("../config/boot.php");
?>

  <!-- Links to  scripts -->

<script src="../js/jquery/jquery-3.1.1.min.js"></script>
<script src="../js/bootstrap/bootstrap.min.js"></script>
<script src="../js/bootstrap/bootstrap-datetimepicker.js"></script>
<script src="../js/jquery/jquery.dataTables.min.js"></script>
<script src="../js/bootstrap/dataTables.bootstrap.min.js"></script>
<script src="../js/highcharts/highcharts.js"></script>
<script src="../js/highcharts/exporting.js"></script>
<script src="../js/app.js"></script>

</body>
</html>
