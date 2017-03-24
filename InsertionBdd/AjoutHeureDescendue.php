<?php
////////Inserer info////////
include('../admin/header.php');
include('../config/boot.php');

$req = $pdo->prepare('INSERT INTO heuresdescendues (heure, DateDescendu, id_Sprint, id_Employe, id_Projet) VALUES(?, ?, ?, ?, ?)');
$req->execute(array($_POST['nbheure'], $_POST['dateDebut'], $_POST['numerosprint'], $_POST['employeid'], $_POST['projetid']));

header('Location: ../admin/page3.php');
?>
