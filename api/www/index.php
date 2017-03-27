<?php

require_once __DIR__.'/../vendor/autoload.php';

require_once __DIR__.'/UserProvider.php';

use Symfony\Component\Security\Core\User\InMemoryUserProvider;
//use JDesrosiers\Silex\Provider\CorsServiceProvider;

$app = new Silex\Application();

$app->register(new Silex\Provider\RoutingServiceProvider());

$app->register(new JDesrosiers\Silex\Provider\CorsServiceProvider(), [
    "cors.allowOrigin" => "*",
]);

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../views',
));

$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
    'db.options' => array(
        'dbname' => 'scrum',
        'user' => 'root',
        'password' => 'simplonmars',
        'host' => 'localhost',
        'driver' => 'pdo_mysql',
    ),
));

// Json WebToken

//  config for security jwt

$app['security.jwt'] = array(
  'secret_key' => '',
  'life_time'  => 86400,  // token valable 24 heures.
  'algorithm'  => ['HS256'],
  'options'    => [
    'username_claim' => 'email',
    'header_name' => 'X-Access-Token', // default null, option for usage normal oauth2 header
    'token_prefix' => 'Bearer',
  ]
);

$app['users'] = function () use ($app) {
    return new UserProvider($app['db']);
};




//  config for silex security

$app['security.firewalls'] = array(
  'login' => [
    'pattern' => 'login|register',//|oauth?
    'anonymous' => true,
  ],
  'unsecured' => [
    'pattern' => '^.*$',
    'anonymous' => true,
  ],
  'secured' => array(
    //'pattern' => '^.*$',
    'pattern' => 'secured',
    'logout' => array('logout_path' => '/logout'),
    'users' => $app['users'],
    'jwt' => array(
      'use_forward' => true,
      'require_previous_session' => false,
      'stateless' => true,
    )
  ),
);

$app->register(new Silex\Provider\SecurityServiceProvider());
$app->register(new Silex\Provider\SecurityJWTServiceProvider());


//

require_once('./sprints.php');
require_once('./employes.php');
require_once('./projets.php');
require_once('./actions.php');
require_once('./users.php');

$app['debug'] = true;
$app["cors-enabled"]($app);

$app->run();
