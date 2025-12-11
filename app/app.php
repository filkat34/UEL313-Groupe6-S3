<?php

use Symfony\Component\Debug\ErrorHandler;
use Symfony\Component\Debug\ExceptionHandler;
use Symfony\Component\HttpFoundation\Request;

// Register global error and exception handlers
ErrorHandler::register();
ExceptionHandler::register();

// Register service providers
$app->register(new Silex\Provider\DoctrineServiceProvider());
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../views',
));
$app['twig'] = $app->share($app->extend('twig', function(Twig_Environment $twig, $app) {
    $twig->addExtension(new Twig_Extensions_Extension_Text());
    return $twig;
}));
$app->register(new Silex\Provider\UrlGeneratorServiceProvider());
$app->register(new Silex\Provider\SessionServiceProvider());
$app->register(new Silex\Provider\SecurityServiceProvider(), array(
    'security.firewalls' => array(
        'secured' => array(
            'pattern' => '^/',
            'anonymous' => true,
            'logout' => true,
            'form' => array('login_path' => '/login', 'check_path' => '/login_check'),
            'users' => $app->share(function () use ($app) {
                return new Watson\DAO\UserDAO($app['db']);
            }),
        ),
    ),
    'security.role_hierarchy' => array(
        'ROLE_ADMIN' => array('ROLE_USER'),
    ),
    'security.access_rules' => array(
        array('^/admin', 'ROLE_ADMIN'),
    ),
));
$app->register(new Silex\Provider\FormServiceProvider());
$app->register(new Silex\Provider\TranslationServiceProvider());
$app->register(new Silex\Provider\ValidatorServiceProvider());

$app->register(new Silex\Provider\MonologServiceProvider(), array(
    'monolog.logfile' => __DIR__.'/../var/logs/watson.log',
    'monolog.name' => 'Watson',
    'monolog.level' => $app['monolog.level']
));
$app->register(new Silex\Provider\ServiceControllerServiceProvider());
if (isset($app['debug']) && $app['debug']) {
    $app->register(new Silex\Provider\HttpFragmentServiceProvider());
}

// Register services
$app['dao.user'] = $app->share(function ($app) {
    return new Watson\DAO\UserDAO($app['db']);
});

$app['dao.tag'] = $app->share(function ($app) {
    return new Watson\DAO\TagDAO($app['db']);
});

$app['dao.link'] = $app->share(function ($app) {
    $linkDAO = new Watson\DAO\LinkDAO($app['db']);
    $linkDAO->setUserDAO($app['dao.user']);
    $linkDAO->setTagDAO($app['dao.tag']);
    return $linkDAO;
});


// Register error handler
$app->error(function (\Exception $e, $code) use ($app) {
    switch ($code) {
        case 403:
            $message = 'Accès refusé.';
            break;
        case 404:
            $message = 'La ressource demandée est introuvable.';
            break;
        default:
            $message = "Une erreur s'est produite.";
    }
    return $app['twig']->render('error.html.twig', array('message' => $message));
});

// Register JSON data decoder for JSON requests
$app->before(function (Request $request) {
    if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
        $data = json_decode($request->getContent(), true);
        $request->request->replace(is_array($data) ? $data : array());
    }
});
