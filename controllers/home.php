<?php

use App\Model\HomepageModel;
use App\Model\PackModel;

$homepageModel = new HomepageModel();
$packModel = new PackModel();

// Show homepage sections (that can be edited by admin)
$sections = $homepageModel->getAllSections();

// Show packs to buy
$packs = $packModel->getAllPacks();

$template = 'home';
include '../templates/base.phtml';