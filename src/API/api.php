<?php

include "Router.php";
include __DIR__ . "/../Service/ComunicadoService.php";

use src\API\Router;
use src\Service\ComunicadoService;
use src\Service\UnidadeDeConservacaoService;

$router = new Router();

$router->get('/comunicado/{id}', ComunicadoService::class, 'getComunicado');
$router->get('/comunicado', ComunicadoService::class, 'getComunicados');
$router->post('/comunicado', ComunicadoService::class, 'createComunicado');

$router->get('/unidade/{id}', UnidadeDeConservacaoService::class, 'getUnidadeDeConservacao');
$router->get('/unidade', UnidadeDeConservacaoService::class, 'getUnidadesDeConservacao');

$router->startRouter();