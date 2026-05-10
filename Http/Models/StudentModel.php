<?php

namespace Http\Models;

use Core\Database;
use Core\App;

class StudentModel
{
    private $db;
    public function __construct()
    {

        $this->db =  App::resolve(Database::class);
    }

    public function CreateStudent($userId, $houseId)
    {
        $this->db->query('INSERT INTO Student (user_id,house_id) VALUES (:userId, :houseId)', [
            'userId'     => $userId,
            'houseId'    => $houseId,

        ]);
        return $this->db->connection->lastInsertId();
    }
}
