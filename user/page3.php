    <html>

        <?php include('header.php');
              include('../config/boot.php');
        ?>

        </br></br>

        <div class="container-fluid">

            <div class="row">

                <div class="col-sm-3">

                    <form method="POST" action="../InsertionBdd/AjoutHeureDescendue.php">

                        <!-- ///  AFFICHER LISTE SPRINT  /// -->
                        <div class="row">
                            <div class="col-sm-11">
                                <div class="form-group">
                                    <label for="sel1">Sprint n°</label>
                                        <select class="form-control"  name="numerosprint">

                                            <?php
                                                $result = $pdo->query("select id, numero from sprint order by id desc");

                                                    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                                                      unset($id, $numero);
                                                      $id = $row['id'];
                                                      $numero = $row['numero'];
                                                      echo '<option value="'.$id.'"> ' .$numero. ' </option>';
                                                    }
                                            ?>
                                        </select>
                               </div>
                            </div>
                        </div>

                        <!-- ///  AFFICHER LISTE Employe  /// -->
                        <div class="row">
                            <div class="col-sm-11">
                                <div class="form-group">
                                    <label for="sel1">Employe</label>
                                        <select class="form-control"  name="employeid">

                                                <?php
                                                    $result = $pdo->query("select id, prenom from employe order by prenom ASC");

                                                    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                                                      unset($id, $nom);
                                                      $id = $row['id'];
                                                      $prenom = $row['prenom'];
                                                      echo '<option value="'.$id.'"> ' .$prenom. ' </option>';
                                                    }
                                                ?>
                                        </select>
                                </div>
                           </div>
                        </div>

                        <!-- /// AFFICHER LISTE Projet  /// -->
                        <div class="row">
                            <div  class="col-sm-11">
                               <div class="form-group">
                                   <label for="sel1">Projet</label>
                                        <select class="form-control"  name="projetid">
                                            <?php

                                            $result = $pdo->query("select id, nom from projet order by nom ASC");

                                            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                                              unset($id, $nom);
                                              $id = $row['id'];
                                              $nom = $row['nom'];
                                              echo '<option value="'.$id.'"> ' .$nom. ' </option>';
                                            }
                                            ?>
                                       </select>
                                </div>
                            </div>
                        </div>

                        <!-- /// Nombre d'heures  /// -->
                        <div class="row">
                            <div class="col-sm-11">
                                <div class="input-group" >
                                    <span class="input-group-addon" >Nb Heures</span>
                                    <input type="number" class="form-control bfh-number" name="nbheure"  min=1 value=1 aria-describedby="basic-addon1" >
                                </div>
                            </div>
                        </div>

                        </br>

                        <!-- ///  AFFICHER L'heure  /// -->
                        <div class="row">
                            <div class="col-sm-11">
                                <div class="form-group">
                                    <div class='input-group date'>
                                        <input type='text' placeholder="Date de Début"  name="dateDebut" id='dateDebut' class="form-control" />
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- ///  AFFICHER bouton  /// -->
                        <div class="row">
                            <div class="col-md-11">
                                <button type="submit" class="btn btn-success btn-block">
                                    <span class="glyphicon glyphicon-upload" aria-hidden="true"></span> Ajouter
                                </button>
                            </div>
                        </div>

                    </form>
                </div>

                <div class="col-sm-6">

                    <h4>Heures descendues par Employé(e), par Projet</h4>

                        <table id="pagination" class="table table-striped">

                            <thead>
                                <tr>
                                    <th>Employé(e)</th>
                                    <th>Projet</th>
                                    <th>Heure(s)</th>
                                    <th>Date</th>
                                    <th>Editer</th>
                                    <th>Supprimer</th>
                                </tr>
                            </thead>

                            <tbody>

                                <!-- ///  AFFICHER LISTE HEURE DESCENDU PAR PERSONNE PAR PROJET PAR DATE  /// -->
                                <?php


                                $reponse = $pdo->query('select  sprint.id as Sprint,
                                heuresdescendues.heure as NbHeure,
                                heuresdescendues.DateDescendu as date,
                                projet.nom as projet, employe.prenom as employe
                                FROM heuresdescendues
                                inner JOIN employe ON heuresdescendues.id_Employe = employe.id
                                INNER JOIN projet on projet.id = heuresdescendues.id_Projet
                                INNER JOIN sprint on sprint.id = heuresdescendues.id_Sprint
                                WHERE id_sprint=(SELECT max(id) FROM sprint)
                                ORDER BY heuresdescendues.id desc');

                                while ($donnees = $reponse->fetch())
                                {
                                    echo "  <tr>";
                                        echo "  <td>";
                                        echo  $donnees['employe'];
                                        echo "  </td>";
                                        echo "  <td>";
                                        echo  $donnees['projet'];
                                        echo "  </td>";
                                        echo "  <td>";
                                        echo  $donnees['NbHeure'];
                                        echo "  </td>";
                                        echo "  <td>";
                                        echo  $donnees['date'];
                                        echo "  </td>";
                                          echo "  <td>";
                                        echo"<button class = \"crudedit \">Editer</button>";
                                         echo "</td>";
                                         echo "<td>";

                                      echo"<button class = \"crudelete \">Supprimer</button>";
                                         echo"</td>";

                                        echo "  </tr>";
                                }

                                $reponse->closeCursor();

                                ?>

                            </tbody>

                        </table>

                </div>

                <!--Total heures descendues par jour-->
                <div class="col-sm-3">

                    <h4>Heures descendues par jours</h4>

                        <table class="table table-striped table-bordered">

                           <thead>
                                <tr>
                                    <th>Total heures</th>
                                    <th>Date</th>
                                </tr>
                            </thead>

                            <tbody>

                                <?php



                                    $reponse = $pdo->query('select  sprint.id as Sprint, sum(heuresdescendues.heure) as totHeure, heuresdescendues.DateDescendu as date
                                    FROM heuresdescendues
                                    inner JOIN employe ON heuresdescendues.id_Employe = employe.id
                                    INNER JOIN sprint on sprint.id = heuresdescendues.id_Sprint
                                    where id_sprint=(SELECT max(id) FROM sprint)
                                    GROUP BY sprint.id, heuresdescendues.DateDescendu');

                                    while ($donnees = $reponse->fetch())
                                    {
                                        echo "  <tr>";
                                            echo "  <td>";
                                            echo  $donnees['totHeure'];
                                            echo "  </td>";
                                            echo "  <td>";
                                            echo  $donnees['date'];
                                            echo "  </td>";
                                            echo "  </tr>";
                                    }

                                        $reponse->closeCursor();

                                ?>

                            </tbody>

                        </table>



                        <table class="table">
                            <thead>
                                <tr>
                                <th>Total heures descendues pour le sprint</th>
                                </tr>
                            </thead>

                            <tbody>

                                <?php



                                $reponse = $pdo->query('select  sprint.id as Sprint, sum(heuresdescendues.heure) as totHeure
                                        FROM heuresdescendues
                                        inner JOIN employe ON heuresdescendues.id_Employe = employe.id
                                        INNER JOIN sprint on sprint.id = heuresdescendues.id_Sprint
                                        where id_sprint=(SELECT max(id) FROM sprint)
                                        GROUP BY sprint.id');

                                while ($donnees = $reponse->fetch())
                                {
                                    echo "  <tr>";
                                        echo "  <td>";
                                        echo  $donnees['totHeure'];
                                        echo "  </td>";
                                    echo "  </tr>";
                                }

                                $reponse->closeCursor();

                                ?>

                            </tbody>

                        </table>

                </div>

            </div>

        </div>


    </html>

    <script type="text/javascript">
    // disable button by default


      $(function() {
          jQuery.fn.extend({
              disable: function(state) {
                  return this.each(function() {
                      this.disabled = state;
                  });
              }
          });

         $('button').disable(true); // true = disabled false= enabled
      });
    </script>
