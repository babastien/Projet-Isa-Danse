<?php

namespace App\Core;

abstract class AbstractModel {

    protected Database $db;

    public function __construct() {
        $this->db = new Database();
    }
}