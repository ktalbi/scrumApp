    <?php

        //Connection à la bdd et insertion des données collectées depuis le form de la page d'attribution des heures
        include('../admin/header.php');
        include('../config/boot.php');

        $req = $pdo->prepare('INSERT INTO attribution (heure, id_Sprint, id_Employe, id_Projet) VALUES(?, ?, ?, ?)');
        $req->execute(array($_POST['nbheure'], $_POST['numerosprint'], $_POST['employeid'], $_POST['projetid']));

        //actualiser la page
        header('Location: ../admin/page2.php');
    ?>
