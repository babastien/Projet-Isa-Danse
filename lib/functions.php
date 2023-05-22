<?php

use App\Model\UserModel;

function asset(string $path)
{
    return BASE_URL . '/' . $path;
}

function constructUrl(string $routeName, array $params = [])
{
    if (!array_key_exists($routeName, ROUTES)) {
        throw new Exception('ERREUR : pas de route nommée ' . $routeName);
    }
    $url = BASE_URL . '/index.php' . ROUTES[$routeName]['path'];

    if ($params) {
        $url .= '?' . http_build_query($params);
    }
    return $url;
}

function slugify(string $string)
{
    $string = preg_replace('/[^\p{L}\p{N}]+/u', '-', $string);

    $string = mb_strtolower($string, 'UTF-8');

    $string = trim($string, '-');

    $string = preg_replace('/-+/', '-', $string);

    return $string;
}

function uploadFileInFolder(array $filesArray, string $folderName)
{
    $extension = pathinfo($filesArray['name'], PATHINFO_EXTENSION);
    $basename = pathinfo($filesArray['name'], PATHINFO_BASENAME);

    $basename = slugify($basename);

    $filename = $basename . sha1(uniqid(rand(), true)) . '.' . $extension;

    if (!file_exists($folderName)) {
        mkdir($folderName);
    }
    move_uploaded_file($filesArray['tmp_name'], $folderName . '/' . $filename);

    return $filename;
}

function cleanData($data)
{
    if (is_string($data)) {
        $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');

    } elseif (is_array($data)) {
        foreach ($data as $key => $value) {
            $data[$key] = cleanData($value);
        }

    } elseif (is_object($data)) {
        $reflection = new ReflectionObject($data);
        $properties = $reflection->getProperties();
        
        foreach ($properties as $property) {
            $property->setAccessible(true);
            $value = $property->getValue($data);
            $cleanedValue = cleanData($value);
            $property->setValue($data, $cleanedValue);
        }
    }

    return $data;
}

function validLoginForm($email_login, $password_login)
{
    $errors = [];

    if (empty($email_login)) {
        $errors['email_login'] = 'Le champ <b>Email</b> doit être rempli';
    } elseif (!filter_var($email_login, FILTER_VALIDATE_EMAIL)) {
        $errors['email_login'] = 'Le format de l\'email est invalide';
    }

    if (empty($password_login)) {
        $errors['password_login'] = 'Le champ <b>Mot de passe</b> doit être rempli';
    }

    return $errors;
}

function validRegisterForm($lastname, $firstname, $email, $password, $password2)
{
    $errors = [];
    $userModel = new UserModel();

    if (empty($lastname)) {
        $errors['lastname'] = 'Le champ <b>Nom</b> doit être rempli';
    } elseif (strlen($lastname) < 3) {
        $errors['lastname'] = 'Le champ <b>Nom</b> doit contenir au moins 3 caractères';
    }

    if (empty($firstname)) {
        $errors['firstname'] = 'Le champ <b>Prénom</b> doit être rempli';
    } elseif (strlen($firstname) < 3) {
        $errors['firstname'] = 'Le champ <b>Prénom</b> doit contenir au moins 3 caractères';
    }

    if (empty($email)) {
        $errors['email'] = 'Le champ <b>Email</b> doit être rempli';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Le format de l\'email est invalide';
    } elseif ($userModel->verifyEmailExist($email) == true) {
        $errors['email'] = 'Cette adresse email est déjà utilisée';
    }

    if (empty($password)) {
        $errors['password'] = 'Le champ <b>Mot de passe</b> doit être rempli';
    } elseif (strlen($password) < 8) {
        $errors['password'] = 'Votre mot de passe doit contenir 8 caractères minimum';
    } elseif (!preg_match('/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9]).{8,}$/', $password)) {
        $errors['password'] = 'Votre mot de passe doit contenir au moins une majuscule, une minuscule et un chiffre';
    }

    if (empty($password2)) {
        $errors['password2'] = 'Le champ <b>Confirmer le mot de passe</b> doit être rempli';
    } elseif ($password != $password2) {
        $errors['password2'] = 'Vos mots de passe doivent être identiques';
    }

    return $errors;
}