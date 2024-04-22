<?php

namespace App\Models;

use Core\Database;

class Jiri extends Database
{
    protected string $table = 'jiris';

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

    public function upcomingBelongingTo(int $id): false|array
    {
        $sql = <<<SQL
        SELECT * FROM $this->table 
                 WHERE user_id = :id
                 AND starting_at <= current_timestamp;

SQL;
        $statement =
            $this->prepare($sql);
        $statement->bindValue(':id', $id);
        $statement->execute();
        return $statement->fetchAll();
    }

    public function passedBelongingTo(int $id): false|array
    {
        $sql = <<<SQL
        SELECT * FROM $this->table 
                 WHERE user_id = :id
                 AND starting_at >= current_timestamp;

SQL;
        $statement =
            $this->prepare($sql);
        $statement->bindValue(':id', $id);
        $statement->execute();
        return $statement->fetchAll();
    }

}