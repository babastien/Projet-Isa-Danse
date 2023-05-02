<?php

namespace App\Model;

use App\Core\AbstractModel;
use App\Entity\Pack;

class PackModel extends AbstractModel {

    function getPackById($id) {
        $sql = 'SELECT * FROM packs
                WHERE id = ?';
        $result = $this->db->getOneResult($sql, [$id]);

        return new Pack($result);
    }

    function getAllPacks() {
        $sql = 'SELECT * FROM packs ORDER BY id ASC';
        return $this->db->getAllResults($sql);
    }

    function addPackToUser($userId, $packId) {
        $sql = 'INSERT INTO users_packs(user_id, pack_id, purchased_on)
                VALUES (?, ?, NOW())';
        $this->db->prepareAndExecute($sql, [$userId, $packId]);
    }

    function deletePackToUser($userId, $packId) {
        $sql = 'DELETE FROM users_packs
                WHERE user_id = ? AND pack_id = ?';
        $this->db->prepareAndExecute($sql, [$userId, $packId]);
    }

    function editPack($packId, $title, $price, $image, $description) {
        $sql = 'UPDATE packs
                SET title = ?, price = ?, image = ?, description = ? WHERE id = ?';
        $this->db->prepareAndExecute($sql, [$title, $price, $image, $description, $packId]);
    }

    function deletePack($packId) {
        $sql = 'DELETE FROM packs
                WHERE id = ?';
        $this->db->prepareAndExecute($sql, [$packId]);
    }

    function createNewPack($title, $price, $image) {
        $sql = 'INSERT INTO packs(title, price, image)
                VALUES (?, ?, ?)';
        $this->db->prepareAndExecute($sql, [$title, $price, $image]);
    }
}