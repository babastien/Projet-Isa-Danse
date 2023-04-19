<?php

use App\Model\UserModel;

function asset(string $path)
{
    return BASE_URL . '/' . $path;
}

function constructUrl(string $path, array $params = [])
{
    $url = BASE_URL . '/index.php' . $path;

    if ($params) {
        $url .= '?' . http_build_query($params);
    }

    return $url;
}

// // Validation du formulaire de connexion
// function validLoginForm($email, $password) {

//     $errors = '';

//     if(empty($email) || empty($password)) {
//         $errors = 'Tous les champs doivent être remplis';
//     }

//     if(!empty($email) AND !filter_var($email, FILTER_VALIDATE_EMAIL)) {
//         $errors = 'Adresse email invalide';
//     }

//     return $errors;
// }

// Validation du formulaire de connexion
function validLoginForm($email_login, $password_login) {

    $errors = [];

    if(empty($email_login)) {
        $errors['email_login'] = '<p class="error">Le champ <b>Email</b> doit être rempli</p>';
    } elseif(!filter_var($email_login, FILTER_VALIDATE_EMAIL)) {
        $errors['email_login'] = '<p class="error">Adresse email invalide</p>';
    }

    if(empty($password_login)) {
        $errors['password_login'] = '<p class="error">Le champ <b>Mot de passe</b> doit être rempli</p>';
    }

    return $errors;
}

// // Validation du formulaire d'inscription
// function validRegisterForm($lastname, $firstname, $email, $password, $password2) {

//     $errors = '';
//     $userModel = new UserModel();

//     if(empty($lastname) || empty($firstname) || empty($email) || empty($password) || empty($password2)) {
//         $errors = 'Tous les champs doivent être remplis';
        
//     } else {

//         if(!empty($email) AND !filter_var($email, FILTER_VALIDATE_EMAIL)) {
//             $errors = 'Adresse email invalide';
//         } elseif($userModel->verifyEmailExist($email) == true) {
//             $errors = 'Cette adresse email est déjà utilisée';
//         }

//         if(strlen($password) < 8) {
//             $errors = 'Votre mot de passe doit contenir 8 caractères minimum';
//         } elseif(!preg_match('#^[a-zA-Z0-9]$#', $password)) {
//             $errors = 'Votre mot de passe doit contenir au moins une majuscule, une minuscule et un chiffre';
//         } elseif($password != $password2) {
//             $errors = 'Vos mots de passe doivent être identiques';
//         }
//     }

//     return $errors;
// }

// Validation du formulaire d'inscription
function validRegisterForm($lastname, $firstname, $email, $password, $password2) {

    $errors = [];
    $userModel = new UserModel();

    if(empty($lastname)) {
        $errors['lastname'] = '<p class="error">Le champ <b>Nom</b> doit être rempli</p>';
    }

    if(empty($firstname)) {
        $errors['firstname'] = '<p class="error">Le champ <b>Prénom</b> doit être rempli</p>';
    }

    if(empty($email)) {
        $errors['email'] = '<p class="error">Le champ <b>Email</b> doit être rempli</p>';
    } elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = '<p class="error">Adresse email invalide</p>';
    } elseif($userModel->verifyEmailExist($email) == true) {
        $errors['email'] = '<p class="error">Cette adresse email est déjà utilisée</p>';
    }

    if(empty($password)) {
        $errors['password'] = '<p class="error">Le champ <b>Mot de passe</b> doit être rempli</p>';
    } elseif(strlen($password) < 8) {
        $errors['password'] = '<p class="error">Votre mot de passe doit contenir 8 caractères minimum</p>';
    } elseif(!preg_match('#^[a-zA-Z0-9]$#', $password)) {
        $errors['password'] = '<p class="error">Votre mot de passe doit contenir au moins une majuscule, une minuscule et un chiffre</p>';
    }

    if(empty($password2)) {
        $errors['password2'] = '<p class="error">Le champ <b>Mot de passe</b> doit être rempli</p>';
    } elseif($password != $password2) {
        $errors['password2'] = '<p class="error">Vos mots de passe doivent être identiques</p>';
    }

    return $errors;
}