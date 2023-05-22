<?php

namespace App\Model;

use App\Core\AbstractModel;

class ForgotPasswordModel extends AbstractModel {

    function verifiyEmailForgotPassword(string $email)
    {
        $sql = 'SELECT email FROM forgot_password
                WHERE email = ?';
        return $this->db->verifyData($sql, [$email]);
    }

    function updateRecupCode(string $email, int $recup_code)
    {
        $sql = 'UPDATE forgot_password
                SET code = ?, confirmation = ? WHERE email = ?';
        $this->db->prepareAndExecute($sql, [$recup_code, 0, $email]);
    }

    function insertRecupCode(string $email, int $recup_code)
    {
        $sql = 'INSERT INTO forgot_password (email, code)
                VALUES (?, ?)';
        $this->db->prepareAndExecute($sql, [$email, $recup_code]);
    }

    function verifyCodeExistsByEmail(string $email)
    {
        $sql = 'SELECT * FROM forgot_password
                WHERE email = ?';
        return $this->db->verifyData($sql, [$email]);
    }

    function confirmCode(string $email)
    {
        $sql = 'UPDATE forgot_password
                SET confirmation = 1
                WHERE email = ?';
        $this->db->prepareAndExecute($sql, [$email]);
    }

    function getCodeConfirmation(string $email)
    {
        $sql = 'SELECT confirmation FROM forgot_password
                WHERE email = ?';
        return $this->db->getOneResult($sql, [$email]);
    }
    
    function deleteForgetPasswordRequest(string $email)
    {
        $sql = 'DELETE FROM forgot_password
                WHERE email = ?';
        $this->db->prepareAndExecute($sql, [$email]);
    }
}