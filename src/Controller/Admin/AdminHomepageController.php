<?php

namespace App\Controller\Admin;

use App\Model\HomepageModel;

class AdminHomepageController {

    function editHomepage()
    {
        // Admin page
        if($_SESSION['user']['role'] !== 'admin') {
            http_response_code(404);
            echo 'Erreur 404 : Page introuvable';
            exit;
        }

        $homepageModel = new HomepageModel();

        // Show homepage sections that can be edited
        $sections = $homepageModel->getAllSections();

        foreach($sections as $section) {
            if(isset($_POST['update-section-'.$section['id']])) {
                $homepageModel->updateSection($_POST['title-'.$section['id']], $_POST['content-'.$section['id']], $section['id']);
                header('Location: ' . $_SERVER['REQUEST_URI']);
                exit;
            }
        }

        $template = 'admin/editHomepage';
        require '../templates/base.phtml';
    }
}