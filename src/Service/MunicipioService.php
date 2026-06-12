<?php

namespace src\Service;
require(__DIR__ . '/../Repository/MunicipioRepository.php');
require(__DIR__ . '/../Entity/MunicipioEntity.php');

use MunicipioEntity;
use MunicipioRepository;

class MunicipioService
{

    public static function getMunicipio(array $urlParams = []): MunicipioEntity|array
    {
        if (!empty($urlParams['id'])) {
            $repository = new MunicipioRepository();


            $municipio = $repository->find((int)$urlParams['id']);

            $municipioEntity = new MunicipioEntity();

            if (!empty($municipio)) {

                $municipioEntity->id = $municipio['id'] ?? null;
                $municipioEntity->nome = $municipio['nome'] ?? null;

                return $municipioEntity;
            }

            return ['error' => 'municipio não encontrado'];
        }

        return ['error' => 'id não informado'];
    }

    public static function getMunicipios(): array
    {

        $repository = new MunicipioRepository();

        return $repository->all();

    }

}