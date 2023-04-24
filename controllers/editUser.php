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

    if(empty($lastname)) {
        $errors['lastname'] = 'Le champ <b>Nom</b> est vide';
    }
    if(empty($fistname)) {
        $errors['firstname'] = 'Le champ <b>Prénom</b> est vide';
    }
    if(empty($email)) {
        $errors['email'] = 'Le champ <b>Email</b> est vide';
    } elseif($userModel->verifyEmailExist($email) == true AND $email != $user['email']) {
        $errors['email'] = 'Cette adresse email est déjà utilisée';
    }

    if(empty($errors)) {
        $userModel->editUser($_GET['id'], $lastname, $firstname, $email);
        header('Location: ' . $_SERVER['REQUEST_URI']);
    }
}

// Supprimer un cours
foreach($userPacks as $pack) {
    if(isset($_POST['delete-'.$pack['pack_id']])) {
        $packModel->deletePackToUser($user['id'], $pack['pack_id']);
        header('Location: ' . $_SERVER['REQUEST_URI']);
    }
}

// Ajouter un cours
$packSelected = '';
if(isset($_POST['add-pack'])) {
    $packSelected = $_POST['pack-selected'];

    $packModel->addPackToUser($_GET['id'], $packSelected);
    header('Location: ' . $_SERVER['REQUEST_URI']);
}

$template = 'editUser';
include '../templates/base.phtml';