<?php

namespace App\Model;

use App\Core\AbstractModel;

class PackModel extends AbstractModel {

    function getOnePack($id) {
        $sql = 'SELECT * FROM packs
                WHERE id = ?';
        return $this->db->getOneResult($sql, [$id]);
    }

    function getAllPacks() {
        $sql = 'SELECT * FROM packs
                ORDER BY id ASC';
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

    // Récupère les données d'un cours par rapport à son ID
    function getPackById($id) {

        $sql = 'SELECT * FROM packs WHERE id = ?';
        return $this->db->getOneResult($sql, [$id]);
    }

    function editPack($packId, $title, $price, $image) {

        $sql = 'UPDATE packs
                SET title = ?, price = ?, image = ?
                WHERE id = ?';
        $this->db->prepareAndExecute($sql, [$title, $price, $image, $packId]);
    }

    function deletePack($packId) {
        $sql = 'DELETE FROM packs
                WHERE id = ?';
        $this->db->prepareAndExecute($sql, [$packId]);
    }

    // Ajoute un nouveau pack
    function createNewPack($title, $price, $image) {

        $sql = 'INSERT INTO packs(title, price, image)
                VALUES (?, ?, ?)';
        $this->db->prepareAndExecute($sql, [$title, $price, $image]);
    }
}