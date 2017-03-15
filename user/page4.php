    <html class="bg">

        <?php
            include('../admin/header.php');?>

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

                        <script>

                            var createChartNEW = function(heures, dates, seuils, sprintou){
                                heures = heures.map(function (x) {
                                    return parseInt(x, 10);
                                });

                                seuils = seuils.map(function (x) {
                                    return parseInt(x, 10);
                                });

                                var x = $("#sprintIdList").val();

                                console.log("Les Informations : ",heures, dates, seuils, sprintou);

                                new Highcharts.Chart({
                                    chart: {
                                     renderTo: 'container'
                                    },
                                    title:{
                                            text: 'BurnDownChart du Sprint n°'+x
                                    },
                                    subtitle:{
                                            text: document.ontouchstart === undefined ?
                                           'Déplace ta souris sur les points pour avoir plus de détails': ''
                                    },
                                    yAxis: {
                                            min: 0,
                                            title: {
                                            text: 'Heures'
                                            }
                                    },
                                    xAxis: {
                                        type: 'datetime',
                                        categories: dates
                                    },
                                    series: [{
                                        name: 'Heures Restantes',
                                        data: heures
                                    },
                                    {
                                        name: 'Seuil',
                                        data: seuils,
                                        color: 'red'
                                    }
                                    ]
                                });
                            };

                        </script>
                </div>
        </div>

        <script>

            var localhost = "localhost:8080";

            /// CHANGER LA VALEUR DE X ( FONCTION APPELEE LORS DE L'APPELLE DE LA FONCTION LORS DE LAPPUIE DU BOUTTON ) ///
            var addNumber = function(){
                x = parseInt($("#sprintIdList").val()) + 1;
                if (x > DernierSprint){
                    x -= 1;
                    }

                return x;
            };

            var removenumber = function(){
                x = parseInt($("#sprintIdList").val()) -1 ;
                if (x < PremierSprint){
                    x += 1
                    }

                return x;
            };

            /// FONCTION POUR RECCUPERER LES DONNEES DEPUIS LE SELECT, LE METTRE DANS LE LIENS DE L'API ET LE METTRE LE RESULTAT DANS LES DIFFERENTES VARIABLE ///
            var misajour = function(){
                        var x = $("#sprintIdList").val();
                        var result = getdatafromurlNEW("http://"+localhost+"/scrum/api/www/action/getChart/"+x);
                        var heures = result[0];
                        var dates = result[1];
                        var seuils = result[2];
                        var sprintou = result[3];
                        createChartNEW(heures, dates, seuils, sprintou);
                        $("#sprintIdList").val(x);
            };

            /// ACTION EFFECTUER APRES AVOIR CHANGER LA VALEUR DE X ( FONCTION APPELEE LORS DE LA PRESSION SUR UN BOUTON ) ///
            var plus1 = function(number){

                var SiErreur = parseInt($("#sprintIdList").val()) + 2;
                $("#sprintIdList").val(addNumber());

                var result = getdatafromurlNEW("http://"+localhost+"/scrum/api/www/action/sprintExist/"+x);

                if (result)
                {
                    misajour();
                }

                else //sinon (donc le sprint est nul, il a un soucie)
                {
                    console.log('Problème sur le sprint à afficher, je vais donc directement au : ', SiErreur);
                    $("#sprintIdList").val(SiErreur);
                    misajour();
                }

            };

            //////////////////////////////////////////////////////////////////
            var moins1 = function(number){

                var SiErreur = parseInt($("#sprintIdList").val()) - 2;
                $("#sprintIdList").val(removenumber());

                var result = getdatafromurlNEW("http://"+localhost+"/scrum/api/www/action/sprintExist/"+x);


                if (result) //si le sprint fonctionne
                {
                    misajour();
                }

                else //sinon ( donc le sprint est nul, il a un soucie)
                {
                   console.log('Problème sur le sprint à afficher, je vais donc directement au : ', $SiErreur);
                   $("#sprintIdList").val(SiErreur);
                   misajour();
                }

            };

            /// FONCTION POUR TRANSFORMER L'URL COMME IL FAUT ///
            var getdatafromurlNEW = function(myurl)
            {
                var toret = null;
                console.log("getdatafromurlNEW", myurl);
                $.ajax({
                    url: myurl,
                    async: true,
                    success: function(result){
                        toret = result;
                    },
                    error: function(xhr){
                        console.log("error NEW", xhr);
                        alert("Le sprint selectionner ne peut être affiché car manque d'info. Veuillez en selectionner un autre. Merci1");
                    }
                });
                return (toret);
                console.log('coucou',toret)
            };

            //Fonction lorsque l'on choisie un nouveau sprint depuis la liste deroulante
            var sprintIdListChanged = function(){

                var x = $("#sprintIdList").val();

                var result = getdatafromurlNEW("http://"+localhost+"/scrum/api/www/action/sprintExist/"+x);

                if (result)
                {
                    misajour();
                }
                else
                {
                    alert("Le sprint selectionner ne peut être affiché car manque d'info. Veuillez en selectionner un autre. Merci2.");
                    x = PremierSprint;
                    $("#sprintIdList").val(x);
                    misajour();
                }

            };

            var result = getdatafromurlNEW("http://"+localhost+"/scrum/api/www/action/getChart/0");

            if (result != null)
            {
                misajour();
            }

            //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        </script>

    </html>
