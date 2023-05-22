<?php

namespace App\Controller\Admin;

use App\Core\AbstractController;
use App\Model\PackModel;
use App\Model\UserModel;

class AdminDashboardController extends AbstractController {

    public function dashboard()
    {
        // Admin page
        if ($_SESSION['user']['role'] !== 'admin') {
            http_response_code(404);
            echo 'Erreur 404 : Page introuvable';
            exit;
        }

        $userModel = new UserModel();
        $packModel = new PackModel();

        // // Show packs list
        $packs = $packModel->getAllPacks();

        // Show users list
        $users = $userModel->getAllUsers();

        $errors = [];
        $title = '';
        $price = '';

        // Create new pack
        if (isset($_POST['create-pack'])) {

            $title = trim(strip_tags($_POST['title']));
            $price = $_POST['price'];
            $image = $_FILES['image'];

            if (empty($title)) {
                $errors['title'] = 'Veuillez donner un titre au pack';
            }
            if (empty($price)) {
                $errors['price'] = 'Veuillez donner un prix au pack';
            }
            if (array_key_exists('image', $_FILES) && $image['error'] != UPLOAD_ERR_NO_FILE) {

                $filesize = filesize($image['tmp_name']);                
                if ($filesize > MAX_UPLOAD_SIZE_IMAGE) {
                    $errors['image'] = 'Votre fichier ne doit pas excéder 1 Mo';
                }

                $allowedMimeTypes = ['image/jpeg', 'image/jpg', 'image/png'];
                $mimeType = mime_content_type($image['tmp_name']);

                if (!in_array($mimeType, $allowedMimeTypes)) {
                    $errors['image'] = 'Type de fichier non autorisé';
                }
            } else {
                $errors['image'] = 'Veuillez choisir une image pour le pack';
            }

            if (empty($errors)) {
                $filename = uploadFileInFolder($image, 'images');
                $packModel->createNewPack($title, $price, $filename);

                header('Location: '. $_SERVER['REQUEST_URI']);
                exit;
            }
        }

        return $this->render('admin/admin', [
            'packs' => $packs, 
            'users' => $users,
            'errors' => $errors,
            'title' => $title,
            'price' => $price
        ]);
    }
}