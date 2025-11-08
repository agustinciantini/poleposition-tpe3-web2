<?php
require_once  './app/libs/router.php';
require_once './app/libs/request.php';
require_once './app/controllers/ResultadosAPIController.php';
require_once './app/controllers/user.api.controller.php';
require_once './app/middlewares/jwt.auth.middleware.php';


$router = new Router();
$router->addMiddleware(new JWTAuthMiddleware());

    #Resultados          endpoint     verbo   controller               metodo
    $router->addRoute('resultados', 'GET','ResultadosAPIController', 'getAllResultados');
    $router->addRoute('resultado/:id','GET', 'ResultadosAPIController','getResultado');
    $router->addRoute('resultado', 'POST',    'ResultadosAPIController','createResultado');
    $router->addRoute('resultado/:id','PUT','ResultadosAPIController','updateResultado');
    $router->addRoute('resultado/:id','DELETE','ResultadosAPIController','deleteResultado');
    
    // Endpoint de autenticación
    $router->addRoute('token', 'GET','UserApiController','getToken');

    // Manejo de la ruta
    $router->route($_GET['resource'], $_SERVER['REQUEST_METHOD']);