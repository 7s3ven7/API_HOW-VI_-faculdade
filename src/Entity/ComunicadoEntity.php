<?php

class ComunicadoEntity
{

    public ?int $id;
    public string $titulo;
    public string $descricao;
    public string $dataCriacao;
    public int $status;
    public UnidadeDeConservacaoEntity $unidadeConservacao;
    public ResponsavelEntity $responsavel;

    public function toArray(): array
    {
        return [
            'id' => $this->id ?? null,
            'titulo' => $this->titulo,
            'descricao' => $this->descricao,
            'data_criacao' => $this->dataCriacao,
            'status' => $this->status,
            'unidade_conservacao' => $this->unidadeConservacao->id,
            'responsavel' => $this->responsavel->id
        ];
    }

}