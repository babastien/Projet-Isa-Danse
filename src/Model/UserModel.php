<?php

namespace App\Model;

use App\Core\AbstractModel;
use App\Entity\User;
// use App\Entity\Pack;

class UserModel extends AbstractModel {

    // Vérifie si l'email existe
    function verifyEmailExist($email) {
        $sql = 'SELECT * FROM users WHERE email = ?';
        $result = $this->db->verifyData($sql, [$email]);
        if($result == 1) {
            return true;
        }
    }

    // Récupère les données d'un utilisateur
    function getUser($email) {
        $sql = 'SELECT * FROM users WHERE email = ?';
        return $this->db->getOneResult($sql, [$email]);
    }

    // Récupère les données d'un utilisateur par rapport à son ID
    function getUserById($id) {
        $sql = 'SELECT * FROM users WHERE id = ?';
        return $this->db->getOneResult($sql, [$id]);
    }

    // Récupère les données de tous les utilisateurs
    function getAllUsers() {
        $sql = 'SELECT * FROM users';
        $results = $this->db->getAllResults($sql);
        $users = [];
        foreach ($results as $result) {
            $users[] = new User($result);
        }
        return $users;
    }

    // Ajoute un nouvel utilisateur
    function addNewUser($lastname, $firstname, $email, $password) {
        $sql = 'INSERT INTO users(lastname, firstname, email, password, createdAt)
                VALUES (?, ?, ?, ?, NOW())';
        $this->db->prepareAndExecute($sql, [$lastname, $firstname, $email, $password]);
    }

    // Récupère les cours de l'utilisateur
    function getUserPacks($userId) {
        $sql = 'SELECT * FROM users_packs AS UC
                INNER JOIN packs AS C
                ON UC.pack_id = C.id
                WHERE user_id = ?';
        $results = $this->db->getAllResults($sql, [$userId]);
        return $results;
    }
    
    function updateUserPassword($email, $new_password) {
        $sql = 'UPDATE users 
                SET password = ? WHERE email = ?';
        $this->db->prepareAndExecute($sql, [$new_password, $email]);
    }

    function editUser($userId, $lastname, $firstname, $email) {
        $sql = 'UPDATE users
                SET lastname = ?, firstname = ?, email = ?
                WHERE id = ?';
        $this->db->prepareAndExecute($sql, [$lastname, $firstname, $email, $userId]);
    }

    function deleteUser($userId) {
        $sql = 'DELETE FROM users
                WHERE id = ?';
        $this->db->prepareAndExecute($sql, [$userId]);
    }
}