<?php

use App\Model\UserModel;

function asset(string $path)
{
    return BASE_URL . '/' . $path;
}

function constructUrl(string $routeName, array $params = [])
{

    if(!array_key_exists($routeName, ROUTES)) {
        throw new Exception('ERREUR : pas de route nommée ' . $routeName);
    }
    $url = BASE_URL . '/index.php' . ROUTES[$routeName]['path'];

    if ($params) {
        $url .= '?' . http_build_query($params);
    }
    return $url;
}

function validLoginForm($email_login, $password_login)
{
    $errors = [];

    if(empty($email_login)) {
        $errors['email_login'] = 'Le champ <b>Email</b> doit être rempli';
    } elseif(!filter_var($email_login, FILTER_VALIDATE_EMAIL)) {
        $errors['email_login'] = 'Le format de l\'email est invalide';
    }
    if(empty($password_login)) {
        $errors['password_login'] = 'Le champ <b>Mot de passe</b> doit être rempli';
    }

    return $errors;
}

function validRegisterForm($lastname, $firstname, $email, $password, $password2)
{
    $errors = [];
    $userModel = new UserModel();

    if(empty($lastname)) {
        $errors['lastname'] = 'Le champ <b>Nom</b> doit être rempli';
    }
    if(empty($firstname)) {
        $errors['firstname'] = 'Le champ <b>Prénom</b> doit être rempli';
    }
    if(empty($email)) {
        $errors['email'] = 'Le champ <b>Email</b> doit être rempli';
    } elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Le format de l\'email est invalide';
    } elseif($userModel->verifyEmailExist($email) == true) {
        $errors['email'] = 'Cette adresse email est déjà utilisée';
    }
    if(empty($password)) {
        $errors['password'] = 'Le champ <b>Mot de passe</b> doit être rempli';
    } elseif(strlen($password) < 8) {
        $errors['password'] = 'Votre mot de passe doit contenir 8 caractères minimum';
    } elseif(!preg_match('/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9]).{8,}$/', $password)) {
        $errors['password'] = 'Votre mot de passe doit contenir au moins une majuscule, une minuscule et un chiffre';
    }
    if(empty($password2)) {
        $errors['password2'] = 'Le champ <b>Confirmer le mot de passe</b> doit être rempli';
    } elseif($password != $password2) {
        $errors['password2'] = 'Vos mots de passe doivent être identiques';
    }

    return $errors;
}

function validPresentForm($lastname, $firstname, $email, $email2)
{
    $errors = [];

    if(empty($lastname)) {
        $errors['lastname'] = 'Le champ <b>Nom</b> doit être rempli';
    }
    if(empty($firstname)) {
        $errors['firstname'] = 'Le champ <b>Prénom</b> doit être rempli';
    }
    if(empty($email)) {
        $errors['email'] = 'Le champ <b>Email</b> doit être rempli';
    } elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Le format de l\'email est invalide';
    }
    if(empty($email2)) {
        $errors['email2'] = 'Le champ <b>Confirmer l\'email</b> doit être rempli';
    } elseif($email != $email2) {
        $errors['email2'] = 'Les emails ne correspondent pas';
    }

    return $errors;
}

function validChangePasswordForm($password, $new_password, $new_password2, $session_password)
{
    $errors = [];

    if(empty($password)) {
        $errors['password'] = 'Veuillez renseigner votre mot de passe actuel';
    } elseif(!password_verify($password, $session_password)) {
        $errors['password'] = 'Le mot passe actuel ne correspond pas';
    }
    if(empty($new_password)) {
        $errors['new_password'] = 'Veuillez entrer un nouveau mot de passe';
    } elseif(!preg_match('/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9]).{8,}$/', $new_password)) {
        $errors['new_password'] = 'Le mot de passe doit contenir au moins 8 caractères dont une majuscule, une minuscule et un chiffre';
    }
    if(empty($new_password2)) {
        $errors['new_password2'] = 'Veuillez confirmer le nouveau mot de passe';
    } elseif($new_password != $new_password2) {
        $errors['new_password2'] = 'Les mots de passe ne correspondent pas';
    }

    return $errors;
}