<?php

namespace App\Controller\Admin;

use App\Core\AbstractController;
use App\Model\HomepageModel;

class AdminHomepageController extends AbstractController {

    public function editHomepage()
    {
        // Admin page
        if ($_SESSION['user']['role'] !== 'admin') {
            http_response_code(404);
            echo 'Erreur 404 : Page introuvable';
            exit;
        }

        $homepageModel = new HomepageModel();

        // Show homepage sections that can be edited
        $sections = $homepageModel->getAllSections();

        foreach ($sections as $section) {
            if (isset($_POST['update-section-'.$section['id']])) {
                $homepageModel->updateSection($_POST['title-'.$section['id']], $_POST['content-'.$section['id']], $section['id']);
                header('Location: ' . $_SERVER['REQUEST_URI']);
                exit;
            }
        }

        return $this->render('admin/editHomepage', [
            'sections' => $sections
        ]);
    }
}