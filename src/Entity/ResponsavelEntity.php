<?php

class ResponsavelEntity
{

    public ?int $id;
    public string $nome;
    public string $email;

    public function toArray(): array
    {
        return [
            'id' => $this->id ?? null,
            'nome' => $this->nome,
            'email' => $this->email
        ];
    }

}