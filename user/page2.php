    <html>
        <?php include('../admin/header.php');
              include('../config/boot.php');
        ?>

        </br></br>

        <div class="container-fluid">

            <div class="row">

                <form method="POST" action="../InsertionBdd/AjoutHeureAttribution.php">

                    <div class="col-sm-3">

                        <!-- /// OBTENIR LISTE SPRINT /// -->
                        <div class="row">
                            <div  class="col-sm-11">
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

                        <!-- /// OBTENIR LISTE PROJET /// -->
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

                        <!-- /// OBTENIR LISTE EMPLOYE  /// -->
                        <div class="row">
                            <div  class="col-sm-11">
                                <div class="form-group">
                                    <?php
                                        $result = $pdo->query("select id, prenom from employe order by prenom ASC");

                                        echo "<label for=\"sel1\">Employe</label>";
                                            echo "<select class=\"form-control\"  name=\"employeid\">";
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

                        <!-- /// Input pour le nombre d'heures d'heures  /// -->
                        <div class="row">
                            <div class="col-sm-11">
                                <div class="input-group" >
                                    <span class="input-group-addon" >Nb Heures</span>
                                    <input type="number" class="form-control bfh-number" name="nbheure"  value=1 aria-describedby="basic-addon1" >
                                </div>
                            </div>
                        </div>

                        </br>

                        <!-- /// Bouton pour créer sprint /// -->
                        <div class="row">
                            <div class="col-md-11">
                                <button type="submit" class="btn btn-success btn-block">
                                  <span class="glyphicon glyphicon-upload" aria-hidden="true"></span> Ajouter
                                </button>
                            </div>
                        </div>
                    </div>
                </form>

                <div class="col-sm-5">

                    <h4>Heures attribuée(s) par Employe, par Projet</h4>

                    <!-- /// AFFICHER LISTE HEURE DESCENDU PAR PERSONNE PAR PROJET PAR DATE  /// -->
                        <?php

                            $reponse = $pdo->query('select sprint.numero as Sprint,
                            attribution.heure as NbHeure,
                            projet.nom as projet,
                            employe.prenom as employe FROM attribution
                            inner JOIN employe ON employe.id = attribution.id_Employe
                            INNER JOIN projet ON projet.id = attribution.id_Projet
                            INNER JOIN sprint ON sprint.id = attribution.id_Sprint where id_sprint=(SELECT max(id) FROM sprint)
                            ORDER BY attribution.id DESC');

                              echo "<table id=\"pagination\" class=\"table table-striped\">";
                                echo "<thead>";
                                 echo " <tr>";
                                    echo "<th>Employé</th>";
                                   echo " <th>Projet</th>";
                                   echo " <th>Heure(s)</th>";
                                   echo "<th>Editer</th>";
                                   echo " <th>Supprimer</th>";
                                echo "  </tr>";
                              echo "  </thead>";
                              echo "  <tbody>";

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
                                echo "<td>";

                                echo"<button class = \"crudedit \">Editer</button>";
                                  echo "</td>";
                                  echo "<td>";

                                  echo"<button class = \"crudelete \">Supprimer</button>";
                                  echo"</td>";
                                echo "  </tr>";
                            }
                                echo "  </tbody>";
                            $reponse->closeCursor();

                            echo "</table>";
                        ?>

                </div>

                <div class="col-sm-3">
                    <?php

                        $reponse = $pdo->query('select  sprint.numero as Sprint, sum(attribution.heure) as totHeure
                                    FROM attribution INNER JOIN sprint on sprint.id = attribution.id_Sprint
                                    where id_sprint=(SELECT max(id) FROM sprint)
                                    GROUP BY sprint.id');

                        echo "<table class=\"table\">";
                                echo "<thead>";
                                 echo " <tr>";
                                    echo "<th>Total heures attribués pour le sprint</th>";
                                echo "  </tr>";
                              echo "  </thead>";
                              echo "  <tbody>";


                        while ($donnees = $reponse->fetch())
                        {
                            echo "  <tr>";
                                echo "  <td>";
                                echo  $donnees['totHeure'];
                                echo "  </td>";
                                echo "  </tr>";
                        }
                        echo "  </tbody>";
                        echo "</table>";
                        $reponse->closeCursor();

                    ?>
                </div>
            </div>
         </div>
        </br>
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
        //  $('button').hide();
      });
    </script>
