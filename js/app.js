/* This "ready" function is invoked thanks to an addEventListener below */

let ready = function() {


    //populate the Drop Down List



    //Set the active class for tab with page name (from header.php )

    $(document).ready(function() {
        var url = window.location.href;
        var array = url.split('/');
        var lastsegment = array[array.length - 1];
        $('li.active').removeClass('active');
        $('a[href="+lastsegment+"]').parent().addClass('active');
    });


    /* datatimepicker creation with a format complying with db
    inserion. Autoclose when date is selected. minView set to 2 */


    $('#dateDebut').datetimepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        minView: 2
    });
    $('#dateFin').datetimepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        minView: 2
    });

    /* Function used to auto-fill today's date in the first date input */


    function DateAujourdhui(_id) {
        let _dat = document.querySelector(_id);
        let aujourdui = new Date(),
            j = aujourdui.getDate(),
            m = aujourdui.getMonth() + 1,
            a = aujourdui.getFullYear(),
            data;


        /* If days and/or month < 10 we concat with a "0"
         so that the format is valid  */


        if (j < 10) {
            j = "0" + j;
        };
        if (m < 10) {
            m = "0" + m;
        };

         data = a + "-" + m + "-" + j;

        _dat.value = data;
    };


    DateAujourdhui('#dateDebut');


    /* Set the second datapicker at today's date +14 days */


    function DateApres(_id) {
        let _dat = document.querySelector(_id);
        let Apres = new Date(),
            j = Apres.getDate() + 14,
            m = Apres.getMonth() + 1,
            a = Apres.getFullYear(),
            data;


        /* When odd months > 31 days update date */



        if ((m == 1) || (m == 3) || (m == 5) || (m == 7) || (m == 9) || (m == 11)) {
            if (j > 31) {
                console.log('Jour avant le changement : ' + j + '  car "jour du début" + 27');
                console.log('Mois avant le changement : ' + m + ' (impair donc 31 jours compris)');
                console.log('-- Passage au prochain mois --');
                j -= 31;
                console.log('Jour après le changement : ' + j)
                m += 1;
                console.log('Mois après le changement : ' + m + '  (soit +1 car nouveau mois)')
            }
        } else {
            if (j > 30) {
                console.log('Jour avant le changement : ' + j);
                console.log('Mois avant le changement : ' + m + ' (pair donc 30 jours compris)');
                console.log('-- Passage au prochain mois --');
                j -= 30;
                console.log('Jour après le changement : ' + j)
                m += 1;
                console.log('Mois après le changement : ' + m + '  (soit +1 car nouveau mois)')
            };
        };


        /* if months > 12 then switch to next year and update to next month. */

        if (m > 12) {
            m -= 12;
            y += 1;
        };

        if (j < 10) {
            j = "0" + j;
        };

        if (m < 10) {
            m = "0" + m;
        };

        data = a + "-" + m + "-" + j;
        _dat.value = data;
    };

    DateApres("#DateFin");



    /*from page2 */

    // script de pagination

    //  $('#pagination').dataTable();
    $(document).ready(function() {
        $('#pagination').DataTable();
    });


    // script associated to modal for updating hours









    // page4

    // Highcharts

    var createChartNEW = function(heures, dates, seuils, sprintou) {
        heures = heures.map(function(x) {
            return parseInt(x, 10);
        });

        seuils = seuils.map(function(x) {
            return parseInt(x, 10);
        });

        var x = $("#sprintIdList").val();

        console.log("Les Informations : ", heures, dates, seuils, sprintou);

        new Highcharts.Chart({
            chart: {
                renderTo: 'container'
            },
            title: {
                text: 'BurnDownChart du Sprint n°' + x
            },
            subtitle: {
                text: document.ontouchstart === undefined ?
                    'Déplace ta souris sur les points pour avoir plus de détails' : ''
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


    var localhost = "localhost:8080";

    /// CHANGER LA VALEUR DE X ( FONCTION APPELEE LORS DE L'APPELLE DE LA FONCTION LORS DE LAPPUIE DU BOUTTON ) ///
    var addNumber = function() {
        x = parseInt($("#sprintIdList").val()) + 1;
        if (x > DernierSprint) {
            x -= 1;
        }

        return x;
    };

    var removenumber = function() {
        x = parseInt($("#sprintIdList").val()) - 1;
        if (x < PremierSprint) {
            x += 1
        }

        return x;
    };

    /// FONCTION POUR RECCUPERER LES DONNEES DEPUIS LE SELECT, LE METTRE DANS LE LIENS DE L'API ET LE METTRE LE RESULTAT DANS LES DIFFERENTES VARIABLE ///
    var misajour = function() {
        var x = $("#sprintIdList").val();
        var result = getdatafromurlNEW("http://" + localhost + "/scrum/api/www/action/getChart/" + x);
        var heures = result[0];
        var dates = result[1];
        var seuils = result[2];
        var sprintou = result[3];
        createChartNEW(heures, dates, seuils, sprintou);
        $("#sprintIdList").val(x);
    };

    /// ACTION EFFECTUER APRES AVOIR CHANGER LA VALEUR DE X ( FONCTION APPELEE LORS DE LA PRESSION SUR UN BOUTON ) ///
    var plus1 = function(number) {

        var SiErreur = parseInt($("#sprintIdList").val()) + 2;
        $("#sprintIdList").val(addNumber());

        var result = getdatafromurlNEW("http://" + localhost + "/scrum/api/www/action/sprintExist/" + x);

        if (result) {
            misajour();
        } else //sinon (donc le sprint est nul, il a un soucie)
        {
            console.log('Problème sur le sprint à afficher, je vais donc directement au : ', SiErreur);
            $("#sprintIdList").val(SiErreur);
            misajour();
        }

    };

    //////////////////////////////////////////////////////////////////
    var moins1 = function(number) {

        var SiErreur = parseInt($("#sprintIdList").val()) - 2;
        $("#sprintIdList").val(removenumber());

        var result = getdatafromurlNEW("http://" + localhost + "/scrum/api/www/action/sprintExist/" + x);


        if (result) //si le sprint fonctionne
        {
            misajour();
        } else //sinon ( donc le sprint est nul, il a un soucie)
        {
            console.log('Problème sur le sprint à afficher, je vais donc directement au : ', $SiErreur);
            $("#sprintIdList").val(SiErreur);
            misajour();
        }

    };

    /// FONCTION POUR TRANSFORMER L'URL COMME IL FAUT ///
    var getdatafromurlNEW = function(myurl) {
        var toret = null;
        console.log("getdatafromurlNEW", myurl);
        $.ajax({
            url: myurl,
            async: true,
            success: function(result) {
                toret = result;
            },
            error: function(xhr) {
                console.log("error NEW", xhr);
                alert("Le sprint selectionner ne peut être affiché car manque d'info. Veuillez en selectionner un autre. Merci1");
            }
        });
        return (toret);
        console.log('coucou', toret)
    };

    //Fonction lorsque l'on choisie un nouveau sprint depuis la liste deroulante
    var sprintIdListChanged = function() {

        var x = $("#sprintIdList").val();

        var result = getdatafromurlNEW("http://" + localhost + "/scrum/api/www/action/sprintExist/" + x);

        if (result) {
            misajour();
        } else {
            alert("Le sprint selectionner ne peut être affiché car manque d'info. Veuillez en selectionner un autre. Merci2.");
            x = PremierSprint;
            $("#sprintIdList").val(x);
            misajour();
        }

    };

    var result = getdatafromurlNEW("http://" + localhost + "/scrum/api/www/action/getChart/0");

    if (result != null) {
        misajour();
    }





    // delete.php javascript and ajax







};

/* When the DOM is loaded, the "ready" function is triggered */
document.addEventListener("DOMContentLoaded", ready);
