<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\ParameterBag;


$app->get('/action/getChart/{numero}', function ($numero) use ($app) {
    $qb = $app['db']->createQueryBuilder('');


    if ($numero <= 0)
    {
        $sql = "SELECT $numero as sprint, burndownhour as value, date as heure , (SELECT sum(interference.heure) FROM interference where interference.id_Sprint = ( SELECT max(sprint.id) FROM sprint )) as interferances FROM `vburndown`where id_Sprint = (SELECT  max(sprint.id) FROM sprint ) order by Date";

    }
    else
    {
        $sql = "SELECT $numero as sprint, burndownhour as value, date as heure , (SELECT sum(interference.heure)  FROM interference where interference.id_Sprint = ( SELECT sprint.id FROM sprint WHERE sprint.numero = $numero )) as interferances FROM `vburndown`where id_Sprint = (SELECT sprint.id FROM sprint WHERE sprint.numero = $numero) order by Date";
    }
    $tmpQuery = $pdo->prepare($sql);
    $tmpQuery->execute();



    $result = $tmpQuery->fetchAll();

    $values = [];
    $hours = [];
    $interferences = [];
    $sprintou = [];

    foreach ($result as $row) {
       $values[] = $row['value'];
       $hours[] = $row['heure'];
       $interferences[] = $row['interferances'];
       $sprintou[] = $row['sprint'];
    }
    if (!$values && !$hours && !$interferences && !$sprintou ){
         $app->abort(404, "Le Sprint n°$numero manque de données pour afficher le tableau" );

    }

    $toReturn[] = $values;
    $toReturn[] = $hours;
    $toReturn[] = $interferences;
    $toReturn[] = $sprintou;
    return $app->json($toReturn);
})->bind('get_action');

$app->get('/action/sprintExist/{numero}', function ($numero) use ($app) {
    $qb = $app['db']->createQueryBuilder('');


    if ($numero != 0)
    {
        $sql = "SELECT $numero as sprint, burndownhour as value, date as heure , (SELECT sum(interference.heure)  FROM interference where interference.id_Sprint = ( SELECT sprint.id FROM sprint WHERE sprint.numero = $numero )) as interferances FROM `vburndown`where id_Sprint = (SELECT sprint.id FROM sprint WHERE sprint.numero = $numero) order by Date";

    }
    else
    {
        return $app->json("envois pas des conneries toi");
    }
    $tmpQuery = $pdo->prepare($sql);
    $tmpQuery->execute();



    $result = $tmpQuery->fetchAll();
    if(count($result) > 0){
        return $app->json(true);
    }else{
        return $app->json(false);
    }
})->bind('get_sprintExist');
