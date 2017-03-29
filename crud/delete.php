<?php

include('../config/boot.php');

    /*
     * Delete entry
     */
        //Connection à la bdd et suppression des données collectées depuis le form de la page d'attribution des heures

        $req = $pdo->prepare('DELETE FROM attribution (heure, id_Sprint, id_Employe, id_Projet) VALUES(?, ?, ?, ?)');
        $req->execute(array($_POST['nbheure'], $_POST['numerosprint'], $_POST['employeid'], $_POST['projetid']));




         if ($_REQUEST['delete']) {

          $pid = $_REQUEST['delete'];
          $query = "DELETE FROM  WHERE product_id=:pid";
          $stmt = $DBcon->prepare( $query );
          $stmt->execute(array(':pid'=>$pid));

          if ($stmt) {
           echo "Product Deleted Successfully ...";
          }

         }
