    <html class="bg">

    <?php include('header.php');
          include('../config/boot.php');

        $req = $pdo->query('SELECT numero as nummax from sprint where id = (SELECT max(id) FROM sprint)');
        $data = $req->fetch();
        ?>

        </br></br></br></br>

        <form method="POST" role="form" action="../InsertionBdd/AjoutSprint.php">

            <div class="container">

                <!-- L'input avec le bon numero du nouveau sprint -->
                <div class="row">
                <div class="col-sm-4"></div>
                        <div class="col-sm-2">
                            <div class="input-group" >
                              <span class="input-group-addon" >Sprint n°</span>
                              <input type="number" class="form-control bfh-number" name="numero"
                              id="numero"
                              min="<?php echo $data['nummax']+1; ?>"
                              max="<?php echo $data['nummax']+1; ?>"
                              value="<?php echo $data['nummax']+1; ?>"
                              aria-describedby="basic-addon1">
                            </div>
                       </div>
                </div>

                </br></br></br>

                <!-- Les date time picker -->
                <div class="row">
                <div class="col-sm-2"></div>
                    <div class='col-md-3'>
                        <div class="form-group">
                            <div class='input-group date'>
                                <input type='text' placeholder="Date de Début"  name="dateDebut" id='dateDebut' class="form-control" />
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class='col-md-3'>
                        <div class="form-group">
                            <div class='input-group date' >
                                <input type='text' placeholder="Date de Fin"  name="dateFin" id='dateFin' class="form-control" />
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

    </br></br>
                <!-- Le Bouton submit -->
                    <div class="row">
                    <div class="col-sm-4"></div>
                        <div class="col-sm-2">
                            <button type="submit" class="btn btn-success btn-block">
                              <span class="glyphicon glyphicon-upload" aria-hidden="true"></span> Créer
                            </button>
                        </div>
                    </div>

            </div>

        </form>

    </html>
