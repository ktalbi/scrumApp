<?php

include('../config/boot.php');


        $req = $pdo->prepare("UPDATE users SET employe = :employe, projet= :projet, heure = :heure  WHERE id = :id");
        $req->bindParam("employe", $employe, PDO::PARAM_STR);
        $req->bindParam("projet", $projet, PDO::PARAM_STR);
        $req->bindParam("heure", $heure, PDO::PARAM_STR);
        $req->execute();
