<?php

namespace App\Core;

use PDO;

class Database {

    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = $this->getPDOConnection();
    }

    function getPDOConnection()
    {
        $dsn = 'mysql:host=' .DB_HOST. ';dbname=' .DB_NAME;
        $options = [PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];
        
        $pdo = new PDO($dsn, DB_USER, DB_PASSWORD, $options);
        $pdo->exec('SET NAMES UTF8');
        return $pdo;
    }

    function prepareAndExecute(string $sql, array $values = [])
    {
        $pdoStatement = $this->pdo->prepare($sql);
        $pdoStatement->execute($values);
        return $pdoStatement;
    }

    function getOneResult(string $sql, array $values = [])
    {
        $pdoStatement = $this->prepareAndExecute($sql, $values);
        return $pdoStatement->fetch();
    }

    function getAllResults(string $sql, array $values = [])
    {
        $pdoStatement = $this->prepareAndExecute($sql, $values);
        return $pdoStatement->fetchAll();
    }

    function verifyData(string $sql, array $values = [])
    {
        $pdoStatement = $this->prepareAndExecute($sql, $values);
        if($pdoStatement->rowCount() == 1) {
            return true;
        }
    }
}