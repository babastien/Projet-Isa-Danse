<?php

namespace App\Controller\Admin;

use App\Core\AbstractController;
use App\Model\UserModel;
use App\Model\PackModel;

class AdminUserController extends AbstractController {

    public function editUser()
    {
        // Admin page
        if ($_SESSION['user']['role'] !== 'admin') {
            http_response_code(404);
            echo 'Erreur 404 : Page introuvable';
            exit;
        }

        $userModel = new UserModel();
        $packModel = new PackModel();

        // Get user's datas
        $user = $userModel->getUserById($_GET['id']);

        // Get user's pack(s)
        $userPacks = $userModel->getUserPacks($user->getId());

        $userPacksId = [];
        foreach ($userPacks as $userPack) {
            $userPacksId[] .= $userPack->getPack()->getId();
        }

        $errors = [];

        // Show packs list
        $packSelection = $packModel->getAllPacks();

        // Edit user
        if (isset($_POST['edit-user'])) {
            $lastname = $_POST['lastname'];
            $firstname = $_POST['firstname'];
            $email = $_POST['email'];

            if (empty($lastname)) {
                $errors['lastname'] = 'Le champ <b>Nom</b> est vide';
            }
            if (empty($firstname)) {
                $errors['firstname'] = 'Le champ <b>Prénom</b> est vide';
            }
            if (empty($email)) {
                $errors['email'] = 'Le champ <b>Email</b> est vide';
            } elseif ($userModel->verifyEmailExist($email) == true AND $email != $user->getEmail()) {
                $errors['email'] = 'Cette adresse email est déjà utilisée';
            }

            if (empty($errors)) {
                $userModel->editUser($_GET['id'], $lastname, $firstname, $email);
                header('Location: ' . $_SERVER['REQUEST_URI']);
                exit;
            }
        }

        // Delete pack to user
        foreach ($userPacks as $userPack) {
            if (isset($_POST['delete-'.$userPack->getPack()->getId()])) {
                $packModel->deletePackToUser($user->getId(), $userPack->getPack()->getId());
                header('Location: ' . $_SERVER['REQUEST_URI']);
                exit;
            }
        }

        // Add pack to user
        $packSelected = '';
        if (isset($_POST['add-pack'])) {
            $packSelected = $_POST['pack-selected'];

            $packModel->addPackToUser($_GET['id'], $packSelected);
            header('Location: ' . $_SERVER['REQUEST_URI']);
            exit;
        }

        // Delete user
        if (isset($_POST['delete-user'])) {
            $userModel->deleteUser($_GET['id']);
            header('Location: ' . constructUrl('admin'));
            exit;
        }

        return $this->render('admin/editUser', [
            'user' => $user,
            'userPacks' => $userPacks,
            'packSelection' => $packSelection,
            'userPacksId' => $userPacksId,
            'errors' => $errors
        ]);
    }
}