<?php

namespace App\Model;

use App\Core\AbstractModel;

class ForgotPasswordModel extends AbstractModel {

    function verifiyEmailForgotPassword($email) {
        $sql = 'SELECT email FROM forgot_password
                WHERE email = ?';
        $result = $this->db->verifyData($sql, [$email]);
        if($result == 1) {
            return true;
        }
    }

    function updateRecupCode($email, $recup_code) {
        $sql = 'UPDATE forgot_password
                SET code = ?, confirmation = ?
                WHERE email = ?';
        $this->db->prepareAndExecute($sql, [$recup_code, 0, $email]);
    }

    function insertRecupCode($email, $recup_code) {
        $sql = 'INSERT INTO forgot_password(email, code)
                VALUES (?, ?)';
        $this->db->prepareAndExecute($sql, [$email, $recup_code]);
    }

    function verifyCodeExist($email) {
        $sql = 'SELECT * FROM forgot_password
                WHERE email = ?';
        $result = $this->db->verifyData($sql, [$email]);
        if($result == 1) {
            return true;
        }
    }

    function confirmCode($email) {
        $sql = 'UPDATE forgot_password
                SET confirmation = 1
                WHERE email = ?';
        $this->db->prepareAndExecute($sql, [$email]);
    }

    function getCodeConfirmation($email) {
        $sql = 'SELECT confirmation FROM forgot_password
                WHERE email = ?';
        return $this->db->getOneResult($sql, [$email]);
    }
    
    function deleteForgetPasswordRequest($email) {
        $sql = 'DELETE FROM forgot_password WHERE email = ?';
        $this->db->prepareAndExecute($sql, [$email]);
    }
}