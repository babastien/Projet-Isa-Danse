<?php

namespace App\Core;

use PDO;

class Database {

    private PDO $pdo;

    public function __construct() {
        $this->pdo = $this->getPDOConnection();
    }

    // Connecte à la BDD
    function getPDOConnection() {

        $dsn = 'mysql:host=' .DB_HOST. ';dbname=' .DB_NAME;
        $options = [PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];
        
        $pdo = new PDO($dsn, DB_USER, DB_PASSWORD, $options);
        $pdo->exec('SET NAMES UTF8');
        return $pdo;
    }

    // Prépare et éxecute une requête SQL
    function prepareAndExecute(string $sql, array $values = []) {

        $pdoStatement = $this->pdo->prepare($sql);
        $pdoStatement->execute($values);
        return $pdoStatement;
    }

    // Récupère un résultat dans la BDD
    function getOneResult(string $sql, array $values = []) {

        $pdoStatement = $this->prepareAndExecute($sql, $values);
        return $pdoStatement->fetch();
    }

    // Récupère tous les résultats dans la BDD
    function getAllResults(string $sql, array $values = []) {

        $pdoStatement = $this->prepareAndExecute($sql, $values);
        return $pdoStatement->fetchAll();
    }

    // Vérifie si une donnée existe dans la BDD
    function verifyData(string $sql, array $values = []) {

        $pdoStatement = $this->prepareAndExecute($sql, $values);
        return $pdoStatement->rowCount();
    }
}