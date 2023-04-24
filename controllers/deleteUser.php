<?php

// Page réservée à l'administrateur
if($_SESSION['role'] !== 'admin') {
    http_response_code(404);
    echo 'Erreur 404 : Page introuvable';
    exit;
}

use App\Model\UserModel;

$userModel = new UserModel();

$user = $userModel->getUserById($_GET['id']);

// Supprimer l'utilisateur
if(isset($_POST['delete-user'])) {
    $userModel->deleteUser($_GET['id']);
    header('Location: ' . constructUrl('/admin'));
    exit;
}

$template = 'deleteUser';
include '../templates/base.phtml';