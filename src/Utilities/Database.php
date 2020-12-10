<?php

namespace App\Utilities;

class Database
{
    public function connect(): \PDO
    {
        $db = new \PDO('mysql:host=localhost:6033;dbname=test_db', 'devuser', 'devpass');
        echo 'connected';
        $db->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);
        return $db;
    }
}