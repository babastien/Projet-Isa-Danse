<?php

namespace App\Model;

use App\Entity\User;
use App\Entity\Pack;
use App\Entity\UserPack;
use App\Core\AbstractModel;

class UserModel extends AbstractModel {

    function verifyEmailExist($email)
    {
        $sql = 'SELECT * FROM users WHERE email = ?';
        $result = $this->db->verifyData($sql, [$email]);
        if($result == 1) {
            return true;
        } else {
            return false;
        }
    }

    function getUserByEmail($email)
    {
        $sql = 'SELECT * FROM users WHERE email = ?';
        $result = $this->db->getOneResult($sql, [$email]);

        return new User($result);
    }

    function getUserById($id)
    {
        $sql = 'SELECT * FROM users WHERE id = ?';
        $result = $this->db->getOneResult($sql, [$id]);

        return new User($result);
    }

    function getAllUsers()
    {
        $sql = 'SELECT * FROM users';
        $results = $this->db->getAllResults($sql);

        $users = [];
        foreach ($results as $result) {
            $users[] = new User($result);
        }
        return $users;
    }

    function addNewUser($lastname, $firstname, $email, $password)
    {
        $sql = 'INSERT INTO users (lastname, firstname, email, password, createdAt)
                VALUES (?, ?, ?, ?, NOW())';
        $this->db->prepareAndExecute($sql, [$lastname, $firstname, $email, $password]);
    }

    function getUserPacks($userId)
    {
        $sql = 'SELECT * FROM users_packs AS UC
                INNER JOIN packs AS C
                ON UC.packId = C.id
                WHERE userId = ?';
        $results = $this->db->getAllResults($sql, [$userId]);

        $packs = [];
        foreach($results as $result) {
            $packs[] = new UserPack($result);
        }
        return $packs;
    }
    
    function updateUserPassword($email, $new_password)
    {
        $sql = 'UPDATE users 
                SET password = ? WHERE email = ?';
        $this->db->prepareAndExecute($sql, [$new_password, $email]);
    }

    function editUser($userId, $lastname, $firstname, $email)
    {
        $sql = 'UPDATE users
                SET lastname = ?, firstname = ?, email = ?
                WHERE id = ?';
        $this->db->prepareAndExecute($sql, [$lastname, $firstname, $email, $userId]);
    }

    function deleteUser($userId)
    {
        $sql = 'DELETE FROM users
                WHERE id = ?';
        $this->db->prepareAndExecute($sql, [$userId]);
    }

    function verifyUserGetPack($userId, $packId): bool
    {
        $sql = 'SELECT * FROM users_packs AS UC
                INNER JOIN packs AS C
                ON UC.packId = C.id
                WHERE userId = ? AND packId = ?';
        $result = $this->db->getAllResults($sql, [$userId, $packId]);
        if($result) {
            return true;
        } else {
            return false;
        }
    }
}