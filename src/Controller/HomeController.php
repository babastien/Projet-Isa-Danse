<?php

namespace App\Controller;

use App\Core\AbstractController;
use App\Model\HomepageModel;
use App\Model\PackModel;

class HomeController extends AbstractController {

    public function index()
    {
        $homepageModel = new HomepageModel();
        $packModel = new PackModel();

        // Show homepage sections that can be edited by admin
        $sections = $homepageModel->getAllSections();

        // Show packs to buy
        $packs = $packModel->getAllPacks();

        return $this->render('home', [
            'sections' => $sections,
            'packs' => $packs
        ]);
    }
}