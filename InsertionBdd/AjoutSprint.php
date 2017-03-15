<?php
////////Inserer info////////
include('../admin/header.php');
include('../config/boot.php');

$req = $pdo->prepare('INSERT INTO sprint (numero, dateDebut, dateFin) VALUES(?, ?, ?)');
$req->execute(array($_POST['numero'], $_POST['dateDebut'], $_POST['dateFin']));

header('Location: ../admin/page2.php');
?>
