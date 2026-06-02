<?php

class MunicipioEntity
{

    public ?int $id;
    public string $nome;

    public function toArray(): array
    {
        return [
            'id' => $this->id ?? null,
            'nome' => $this->nome
        ];
    }
}