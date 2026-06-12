<?php

class ResponsavelRepository extends BaseRepository
{
    public string $table = 'responsavel';

    public function findByEmail(string $email): array|bool
    {
        $query = 'SELECT * FROM ' . $this->table . ' WHERE email = :email';

        $stmt = $this->execute($query, ['email' => $email]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

}