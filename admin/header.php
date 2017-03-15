<!DOCTYPE html>

<html>
<head>
    <meta charset="utf-8">
<link rel="stylesheet" href="../css/dataTables.bootstrap.min.css"/>
<link rel="stylesheet" href="../css/bootstrap.css" />
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

<script src="../js/jquery-3.1.1.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/bootstrap-datetimepicker.js"></script>
<script src="../js/jquery.dataTables.min.js"></script>
<script src="../js/dataTables.bootstrap.min.js"></script>
<script src="../js/highcharts.js"></script>
<script src="../js/exporting.js"></script>
<script>
//Set the active class for tab with page name
    $(document).ready(function(){
        var url = window.location.href;
        var array = url.split('/');
        var lastsegment = array[array.length-1];
        $('li.active').removeClass('active');
        $('a[href="+lastsegment+"]').parent().addClass('active');
    });


</script>
</body>
</html>
