<?php

class UnidadeDeConservacaoEntity
{

    public ?int $id;
    public string $nome;
    public DateTime $dataCriacao;
    public string $descricao;
    public string $imagem;
    public ResponsavelEntity $responsavel;

    public function toArray(): array
    {
        return [
            'id' => $this->id ?? null,
            'nome' => $this->nome,
            'dataCriacao' => $this->dataCriacao,
            'descricao' => $this->descricao,
            'imagem' => $this->imagem,
            'responsavel' => $this->responsavel->id
        ];
    }
}