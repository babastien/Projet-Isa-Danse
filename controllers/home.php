<?php

use App\Model\PackModel;

$packModel = new PackModel();

$packs = $packModel->getAllPacks();

$template = 'home';
include '../templates/base.phtml';