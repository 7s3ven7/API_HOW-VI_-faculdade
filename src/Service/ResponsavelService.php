<?php

namespace src\Service;

require(__DIR__ . '/../Repository/ResponsavelRepository.php');
require(__DIR__ . '/../Entity/ResponsavelEntity.php');

use ResponsavelEntity;
use ResponsavelRepository;

class ResponsavelService
{

    public function getResponsavel(array $urlParams = []): ResponsavelEntity|array
    {

        if (empty($urlParams['id'])) {

            return ['error' => 'id não informado'];
        }
        $repository = new ResponsavelRepository();

        $responsavel = $repository->find((int)$urlParams['id']);

        if (empty($responsavel)) {
            return ['error' => 'responsavel não encontrado'];
        }

        $responsavelEntity = new ResponsavelEntity();

        $responsavelEntity->id = $responsavel['id'];
        $responsavelEntity->nome = $responsavel['nome'];
        $responsavelEntity->email = $responsavel['email'];

        return $responsavelEntity;
    }

    public function createResponsavel(array $body = []): ResponsavelEntity|array
    {

        if (empty($body['nome'])) {
            return ['error' => 'Nome não informado'];
        }

        if (empty($body['email'])) {
            return ['error' => 'email não informado'];
        }

        $entity = new ResponsavelEntity();

        $entity->nome = $body['nome'];
        $entity->email = $body['email'];

        $repository = new ResponsavelRepository();

        $responsavel = $repository->findByEmail($body['email']);

        if (!empty($responsavel)) {
            return ['error' => 'email já cadastrado'];
        }

        if (!$repository->insert($entity->toArray())) {
            return ['error' => 'não foi possivel cadastrar este responsavel'];
        }

        $responsavel = $repository->findByEmail($body['email']);

        if (empty($responsavel)) {
            return ['error' => 'Não foi possivel cadastrar este responsavel'];
        }

        $entity = new ResponsavelEntity();

        $entity->id = $responsavel['id'];
        $entity->nome = $responsavel['nome'];
        $entity->email = $responsavel['email'];

        return $entity;
    }

}