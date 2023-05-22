<?php

namespace App\Model;

use App\Core\AbstractModel;
use App\Entity\Video;

class VideoModel extends AbstractModel {

    function getVideosByPack($packId)
    {
        $sql = 'SELECT * FROM videos
                WHERE packId = ?
                ORDER BY rankOrder ASC';
        $results = $this->db->getAllResults($sql, [$packId]);

        $videos = [];
        foreach ($results as $result) {
            $videos[] = new Video($result);
        }
        return $videos;
    }

    function addVideo($packId, $title, $filename, $rank_order)
    {
        $sql = 'INSERT INTO videos (packId, title, filename, rankOrder)
                VALUES (?, ?, ?, ?)';
        $this->db->prepareAndExecute($sql, [$packId, $title, $filename, $rank_order]);
    }

    function editVideo($packId, $title, $filename, $rank_order, $videoId)
    {
        $sql = 'UPDATE videos
                SET packId = ?, title = ?, filename = ?, rankOrder = ? WHERE id = ?';
        $this->db->prepareAndExecute($sql, [$packId, $title, $filename, $rank_order, $videoId]);
    }

    function deleteVideo($videoId)
    {
        $sql = 'DELETE FROM videos
                WHERE id = ?';
        $this->db->prepareAndExecute($sql, [$videoId]);
    }
}