<?php

namespace App\Models;

use Core\Database;

class Contact extends Database
{
    protected string $table = 'contacts';

    public function belongingTo(int $id): false|array
    {
        $sql = <<<SQL
        SELECT * FROM $this->table WHERE user_id = :id;

SQL;
        $statement =
            $this->prepare($sql);
        $statement->bindValue(':id', $id);
        $statement->execute();
        return $statement->fetchAll();
    }
}