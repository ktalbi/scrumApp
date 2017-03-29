<?php

    //Connection à la bdd et suppression des données collectées depuis le form de la page d'attribution des heures
    include('../admin/header.php');
    include('../config/boot.php');


    if ($_REQUEST['delete']) {

      $id = $_REQUEST['delete'];
      $query = "DELETE FROM attribution WHERE id=:id";
      $req = $pdo->prepare( $query );
      $req->execute(array(':id'=>$id));

      if ($req) {
       echo "Product Deleted Successfully ...";
      }

     }
     //actualiser la page
     header('Location: ../admin/page3.php');
