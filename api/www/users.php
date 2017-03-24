<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\ParameterBag;

$app->get('/users', function (Request $request) use ($app) {
  return $app->json('ok');
});

$app->post('/users/login', function (Request $request) use ($app) {
  $data = json_decode($request->getContent(), true);



  $qb = $app['db']->createQueryBuilder('');
  $qb
      ->select('*')
      ->from('users', 'u')
      ->where('email = :email')->setParameter('email', $data['email'])
      ->andWhere('password = :password')->setParameter('password', md5($data['password']))
  ;


  $res = $qb->execute()->fetchAll();

  if (count($res) < 1) {
      $app->abort(401);
  }

  $user = $res[0];
  unset($user['password']);

  $response = array(
   'token' => $app['security.jwt.encoder']->encode(array(
     'email' => $user['email']
   )),
 );

  return $app->json($response);
})->bind('login');
