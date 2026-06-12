<?php

namespace src\Service;
require(__DIR__ . '/../Repository/ComunicadoRepository.php');
require(__DIR__ . '/../Entity/ComunicadoEntity.php');
require(__DIR__ . '/ResponsavelService.php');
require(__DIR__ . '/UnidadeDeConservacaoService.php');

use ComunicadoEntity;
use ComunicadoRepository;
use DateTime;
use Exception;

class ComunicadoService
{

    /**
     * @throws Exception
     */
    public function getComunicado(array $urlParams = []): ComunicadoEntity|array
    {

        if (!empty($urlParams['id'])) {

            $repository = new ComunicadoRepository();

            $comunicado = $repository->find((int)$urlParams['id']);

            if (!empty($comunicado)) {

                $comunicadoEntity = new ComunicadoEntity();

                $comunicadoEntity->id = $comunicado['id'];
                $comunicadoEntity->descricao = $comunicado['descricao'];
                $comunicadoEntity->status = $comunicado['status'];
                $comunicadoEntity->dataCriacao = $comunicado['data_criacao'];
                $comunicadoEntity->titulo = $comunicado['titulo'];

                $responsavelService = new ResponsavelService();

                $responsavel = $responsavelService->getResponsavel(['id' => $comunicado['responsavel']]);

                if (!is_object($responsavel)) {
                    return $responsavel;
                }

                $comunicadoEntity->responsavel = $responsavel;
                $unidadeDeConservacaoService = new UnidadeDeConservacaoService();
                $unidadeDeConservacao = $unidadeDeConservacaoService->getUnidadeDeConservacao(['id' => $comunicado['unidade_conservacao']]);

                if (!is_object($unidadeDeConservacao)) {
                    return $unidadeDeConservacao;
                }

                $comunicadoEntity->unidadeConservacao = $unidadeDeConservacao;

                return $comunicadoEntity;
            }

        }

        return ['error' => 'id não informado'];

    }

    /**
     * @throws Exception
     */
    public function getComunicados(array $urlParams = []): array
    {

        $comunicadosRetornados = [];

        $repository = new ComunicadoRepository();

        $responsavelService = new ResponsavelService();
        $unidadeDeConservacaoService = new UnidadeDeConservacaoService();

        $comunicados = $repository->all();

        foreach ($comunicados as $comunicado) {

            $comunicadoEntity = new ComunicadoEntity();

            $comunicadoEntity->id = $comunicado['id'];
            $comunicadoEntity->descricao = $comunicado['descricao'];
            $comunicadoEntity->status = $comunicado['status'];
            $comunicadoEntity->dataCriacao = $comunicado['data_criacao'];
            $comunicadoEntity->titulo = $comunicado['titulo'];

            $responsavel = $responsavelService->getResponsavel(['id' => $comunicado['responsavel']]);

            if (!is_object($responsavel)) {
                return $responsavel;
            }

            $comunicadoEntity->responsavel = $responsavel;

            $unidadeDeConservacao = $unidadeDeConservacaoService->getUnidadeDeConservacao(['id' => $comunicado['unidade_conservacao']]);

            if (!is_object($unidadeDeConservacao)) {
                return $unidadeDeConservacao;
            }

            $comunicadoEntity->unidadeConservacao = $unidadeDeConservacao;

            $comunicadosRetornados[] = $comunicadoEntity;
        }

        return $comunicadosRetornados;
    }

    /**
     * @throws Exception
     */
    public function createComunicado(array $body = []): ComunicadoEntity|array
    {

        if (empty($body['titulo'])) {
            return ['error' => 'Titulo não informado'];
        }

        if (empty($body['descricao'])) {
            return ['error' => 'Descricao não informado'];
        }

        if (empty($body['status'])) {
            return ['error' => 'Status não informado'];
        }

        if (empty($body['responsavel'])) {
            return ['error' => 'responsavel não informado'];
        }

        if (empty($body['unidade_conservacao'])) {
            return ['error' => 'Unidade de conservação não informado'];
        }

        if (empty($body['responsavel']['id'])) {

            if (empty($body['responsavel']['nome']) && empty($body['responsavel']['email'])) {
                return ['error' => 'id || nome && email não informado no responsavel'];
            }

            $responsavelService = new ResponsavelService();

            $responsavel = $responsavelService->createResponsavel($body['responsavel']);

            if(!is_object($responsavel)) {
                return $responsavel;
            }

        } else {
            $responsavelService = new ResponsavelService();

            $responsavel = $responsavelService->getResponsavel($body['responsavel']);

            if (!is_object($responsavel)) {
                return $responsavel;
            }

        }

        $unidadeDeConservacaoService = new UnidadeDeConservacaoService();

        $unidadeDeConservacao = $unidadeDeConservacaoService->getUnidadeDeConservacao(['id' => $body['unidade_conservacao']]);

        if (!is_object($unidadeDeConservacao)) {
            return $unidadeDeConservacao;
        }

        $entity = new ComunicadoEntity();

        $entity->titulo = $body['titulo'];
        $entity->descricao = $body['descricao'];
        $entity->status = $body['status'];
        $entity->responsavel = $responsavel;
        $entity->unidadeConservacao = $unidadeDeConservacao;

        $data = new DateTime();

        $entity->dataCriacao = $data->format('Y-m-d H:i:s');

        $repository = new ComunicadoRepository();

        if (!$repository->insert($entity->toArray())) {
            return ['error' => 'Não foi possivel cadastrar este comunicado'];
        }

        $comunicado = $repository->find($repository->lastId);

        if (empty($comunicado)) {
            return ['error' => 'Não foi possivel encontrar este comunicado'];
        }

        $entity = new ComunicadoEntity();

        $responsavel = $responsavelService->getResponsavel(['id' => $comunicado['responsavel']]);
        $unidadeDeConservacao = $unidadeDeConservacaoService->getUnidadeDeConservacao(['id' => $comunicado['unidade_conservacao']]);
        $entity->titulo = $comunicado['titulo'];
        $entity->descricao = $comunicado['descricao'];
        $entity->status = $comunicado['status'];
        $entity->responsavel = $responsavel;
        $entity->unidadeConservacao = $unidadeDeConservacao;

        return $entity;
    }

}