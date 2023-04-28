<?php

namespace App\Model;

use App\Core\AbstractModel;

class HomepageModel extends AbstractModel {

    function getAllSections() {
        $sql = 'SELECT * FROM homepage ORDER BY id ASC';
        $results = $this->db->getAllResults($sql);

        return $results;
    }

    function updateSection($title, $content, $sectionId) {
        $sql = 'UPDATE homepage
                SET title = ?, content = ?
                WHERE id = ?';

        $this->db->prepareAndExecute($sql, [$title, $content, $sectionId]);
    }
}