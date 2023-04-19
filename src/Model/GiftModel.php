<?php

namespace App\Model;

use App\Core\AbstractModel;

class GiftModel extends AbstractModel {

    function createGiftCode($email, $code, $course_id) {

        $sql = 'INSERT INTO gift(course_id, code, purchased_by, purchased_on)
                VALUES (?, ?, ?, NOW())';
        $this->db->prepareAndExecute($sql, [$course_id, $code, $email]);
    }

    function getGiftCodeDatas($code) {

        $sql = 'SELECT * FROM gift
                WHERE code = ?';
        return $this->db->getOneResult($sql, [$code]);
    }

    function validGiftCode($code) {

        $sql = 'UPDATE gift SET used = 1
                WHERE code = ?';
        $this->db->prepareAndExecute($sql, [$code]);
    }
}