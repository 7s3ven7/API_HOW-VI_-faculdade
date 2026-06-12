<?php

namespace src\Service;

require(__DIR__ . '/../Repository/UnidadeDeConservacaoRepository.php');
require(__DIR__ . '/../Entity/UnidadeDeConservacaoEntity.php');

use DateTime;
use Exception;
use UnidadeDeConservacaoEntity;
use UnidadeDeConservacaoRepository;

class UnidadeDeConservacaoService
{

    /**
     * @throws Exception
     */
    public static function getUnidadeDeConservacao(array $urlParams = []): UnidadeDeConservacaoEntity|array
    {
        if (!empty($urlParams['id'])) {
            $unidadeDeConservacaoRepository = new UnidadeDeConservacaoRepository();

            $unidadeDeConservacao = $unidadeDeConservacaoRepository->find((int)$urlParams['id']);

            if (!empty($unidadeDeConservacao)) {

                $unidadeDeConservacaoEntity = new UnidadeDeConservacaoEntity();

                $unidadeDeConservacaoEntity->id = $unidadeDeConservacao['id'];
                $unidadeDeConservacaoEntity->nome = $unidadeDeConservacao['nome'];
                $unidadeDeConservacaoEntity->dataCriacao = new DateTime($unidadeDeConservacao['data_criacao']);
                $unidadeDeConservacaoEntity->descricao = $unidadeDeConservacao['descricao'];
                $unidadeDeConservacaoEntity->imagem = $unidadeDeConservacao['imagem'];

                $responsavelService = new ResponsavelService();

                $responsavelEntity = $responsavelService->getResponsavel(['id' => $unidadeDeConservacao['responsavel']]);

                if (!is_object($responsavelEntity)) {
                    return $responsavelEntity;
                }

                $unidadeDeConservacaoEntity->responsavel = $responsavelEntity;

                return $unidadeDeConservacaoEntity;
            }

            return ['error' => 'Unidade de Conservação não encontrada'];

        }

        return ['error' => 'id não informado'];
    }

    /**
     * @throws Exception
     */
    public static function getUnidadesDeConservacao(array $urlParams = []): array
    {
        $retornoUnidadesDeConservacao = [];

        $repository = new UnidadeDeConservacaoRepository();
        $responsavelService = new ResponsavelService();

        $unidades = $repository->All();

        foreach ($unidades as $unidade) {
            $unidadeEntity = new UnidadeDeConservacaoEntity();

            $unidadeEntity->id = $unidade['id'];
            $unidadeEntity->nome = $unidade['nome'];
            $unidadeEntity->dataCriacao = new DateTime($unidade['data_criacao']);
            $unidadeEntity->descricao = $unidade['descricao'];
            $unidadeEntity->imagem = $unidade['imagem'];

            $responsavelEntity = $responsavelService->getResponsavel(['id' => $unidade['responsavel']]);

            if (!is_object($responsavelEntity)) {
                return $responsavelEntity;
            }

            $unidadeEntity->responsavel = $responsavelEntity;

            $retornoUnidadesDeConservacao[] = $unidadeEntity;
        }

        return $retornoUnidadesDeConservacao;
    }
}