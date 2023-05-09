<?php

namespace App\Model;

use App\Core\AbstractModel;

class VideoModel extends AbstractModel {

    function getVideosByPack($packId)
    {
        $sql = 'SELECT * FROM videos
                WHERE packId = ?
                ORDER BY rank_order ASC';
        return $this->db->getAllResults($sql, [$packId]);
    }

    function addVideo($packId, $title, $filename, $rank_order)
    {
        $sql = 'INSERT INTO videos (packId, title, filename, rank_order)
                VALUES (?, ?, ?, ?)';
        $this->db->prepareAndExecute($sql, [$packId, $title, $filename, $rank_order]);
    }

    function editVideo($packId, $title, $filename, $rank_order, $videoId)
    {
        $sql = 'UPDATE videos
                SET packId = ?, title = ?, filename = ?, rank_order = ?
                WHERE id = ?';
        $this->db->prepareAndExecute($sql, [$packId, $title, $filename, $rank_order, $videoId]);
    }

    function deleteVideo($videoId)
    {
        $sql = 'DELETE FROM videos
                WHERE id = ?';
        $this->db->prepareAndExecute($sql, [$videoId]);
    }
}