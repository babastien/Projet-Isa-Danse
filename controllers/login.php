<?php

use App\Model\UserModel;

$new_user = null;
if(array_key_exists('new_user', $_SESSION) AND $_SESSION['new_user']) {
    $new_user = $_SESSION['new_user'];
    $_SESSION['new_user'] = null;
    session_unset();
}

if(isset($_POST) AND !empty($_POST)) {

    $email = $_POST['email'];
    $password = $_POST['password'];
    $success = '';

    $errors = validLoginForm($email, $password);

    if(empty($errors) AND !empty($email) AND !empty($password)) {
        $userModel = new UserModel();
        $user = $userModel->getUser($email);

        if($user) {
            $password_user = $user['password'];

            if(password_verify($password, $password_user)) {
                
                $_SESSION['id'] = $user['id'];
                $_SESSION['role'] = $user['role'];
                $_SESSION['firstname'] = $user['firstname'];
                $_SESSION['lastname'] = $user['lastname'];
                $_SESSION['email'] = $user['email'];

                $userCourses = $userModel->getUserCourses($user['id']);

                if(!empty($userCourses)) {

                    // foreach($userCourses as $index => $array) {
                    //     $coursesTab[] = $array['course_id'];
                    // }
                    // $_SESSION['courses'] = $coursesTab;

                    $_SESSION['courses'] = $userCourses;

                } else {
                    $_SESSION['courses'] = [];
                }

                // dump($_SESSION['courses']);
                
                header('Location: ' . constructUrl('/home'));
                exit;

            } else {
                $errors = 'Mauvais email ou mot de passe';
            }
        } else {
            $errors = 'Mauvais email ou mot de passe';
        }
    }
}

$template = 'login';
include '../templates/base.phtml';