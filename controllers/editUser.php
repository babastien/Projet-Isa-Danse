<?php

// Page réservée à l'administrateur
if($_SESSION['role'] !== 'admin') {
    http_response_code(404);
    echo 'Erreur 404 : Page introuvable';
    exit;
}

use App\Model\UserModel;
use App\Model\PackModel;

$userModel = new UserModel();
$packModel = new PackModel();

// Récupère un utilisateur
$user = $userModel->getUserById($_GET['id']);

// Récupère les cours de l'utilisateur
$userPacks = $userModel->getUserPacks($user['id']);

// Récupère la liste des cours
$packs = $packModel->getAllPacks();

// Modifier l'utilisateur
if(isset($_POST['edit-user'])) {
    $lastname = $_POST['lastname'];
    $firstname = $_POST['firstname'];
    $email = $_POST['email'];

    if($userModel->verifyEmailExist($email) == true AND $email != $user['email']) {
        $errors['email'] = '<p class="error">Cette adresse email est déjà utilisée</p>';
    } else {

        $userModel->editUser($_GET['id'], $lastname, $firstname, $email);
        header('Location: ' . constructUrl('/admin'));
    }
}

// Supprimer un cours
foreach($userPacks as $pack) {
    if(isset($_POST['delete-'.$pack['pack_id']])) {
        $packModel->deletePackToUser($user['id'], $pack['pack_id']);
    header('Location: ' . constructUrl('/admin'));
    }
}

// Ajouter un cours
$packSelected = '';
if(isset($_POST['add-pack'])) {
    $packSelected = $_POST['pack-selected'];

    $packModel->addPackToUser($_GET['id'], $packSelected);
    header('Location: ' . constructUrl('/admin'));
}

$template = 'editUser';
include '../templates/base.phtml';