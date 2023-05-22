<?php

namespace App\Model;

use App\Core\AbstractModel;
use App\Entity\Pack;
use App\Model\VideoModel;

class PackModel extends AbstractModel {

    function getPackById($id)
    {
        $sql = 'SELECT * FROM packs
                WHERE id = ?';
        $result = $this->db->getOneResult($sql, [$id]);

        return new Pack($result);
    }

    function getAllPacks()
    {
        $videoModel = new VideoModel();
        
        $sql = 'SELECT * FROM packs ORDER BY id ASC';
        $results = $this->db->getAllResults($sql);

        $packs = [];
        foreach ($results as $result) {
            $result['videos'] = $videoModel->getVideosByPack($result['id']);
            $packs[] = new Pack($result);
        }
        return $packs;
    }

    function addPackToUser($userId, $packId)
    {
        $sql = 'INSERT INTO users_packs (userId, packId, purchasedOn)
                VALUES (?, ?, NOW())';
        $this->db->prepareAndExecute($sql, [$userId, $packId]);
    }

    function deletePackToUser($userId, $packId)
    {
        $sql = 'DELETE FROM users_packs
                WHERE userId = ? AND packId = ?';
        $this->db->prepareAndExecute($sql, [$userId, $packId]);
    }

    function editPack($packId, $title, $price, $image, $description)
    {
        $sql = 'UPDATE packs
                SET title = ?, price = ?, image = ?, description = ? WHERE id = ?';
        $this->db->prepareAndExecute($sql, [$title, $price, $image, $description, $packId]);
    }

    function deletePack($packId)
    {
        $sql = 'DELETE FROM packs
                WHERE id = ?';
        $this->db->prepareAndExecute($sql, [$packId]);
    }

    function createNewPack($title, $price, $image)
    {
        $sql = 'INSERT INTO packs (title, price, image)
                VALUES (?, ?, ?)';
        $this->db->prepareAndExecute($sql, [$title, $price, $image]);
    }

    function verifyPackExists($packId)
    {
        $sql = 'SELECT * FROM packs WHERE id = ?';
        return $this->db->verifyData($sql, [$packId]);
    }
}