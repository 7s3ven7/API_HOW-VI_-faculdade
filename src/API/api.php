<?php

include "Router.php";
include __DIR__ . "/../Service/MunicipioService.php";

use src\API\Router;
use src\Service\MunicipioService;

$router = new Router();

$router->get('/municipio/{id}', MunicipioService::class, 'getMunicipio');
$router->get('/municipio', MunicipioService::class, 'getMunicipios');

$router->startRouter();