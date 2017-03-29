    <html class="bg">

        <?php
            include('header.php');
            include('../config/boot.php');
            ?>

                    </br>

        <div class="container">

            <div class="row">

                <!-- /// Bouton /// -->
                <div class="col-md-2">
                    <button  class="btn btn-primary btn-block" onClick="moins1()">
                      <span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span>
                    </button>
                </div>

                <!-- ///  AFFICHER LISTE SPRINT  /// -->
               <div  class="col-md-8">
                    <div class="form-group">
                        <select class="form-control"  id="sprintIdList" onchange='sprintIdListChanged();'>
                            <?php
                            $result = $pdo->query("select id, numero from sprint order by id desc");

                                            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                                              unset($id, $numero);
                                              $id = $row['id'];
                                              $numero = $row['numero'];
                                              echo '<option value="'.$numero.'"> ' .$numero. ' </option>';
                                                if (!$lastNumero)
                                                    $lastNumero = $numero;
                                                if ($numero < $numero+1)
                                                    $firstNumero = $numero;
                                            }
                                            echo "<script>
                                            var PremierSprint = $firstNumero;
                                            var DernierSprint = $lastNumero;
                                            console.log('Le premier sprint a pour numero : ', $firstNumero);
                                            console.log('Le dernier sprint a pour numero : ', $lastNumero);
                                            </script>";
                            ?>
                        </select>
                    </div>
                </div>

                <!-- /// BOUTON -> /// -->
                    <div class="col-md-2">

                        <button  class="btn btn-primary btn-block" onClick="plus1()">
                          <span class="glyphicon glyphicon-arrow-right" aria-hidden="true"></span>
                        </button>

                    </div>

            </div>

        </div>

        </br></br>

        <div class="container-fluid">
            <div class="col-md-1"></div>
                <div class="col-md-5">
                    <div id="container"></div>

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
