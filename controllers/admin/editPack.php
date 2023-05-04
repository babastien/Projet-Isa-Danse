<?php

// Admin page
if($_SESSION['user']['role'] !== 'admin') {
    http_response_code(404);
    echo 'Erreur 404 : Page introuvable';
    exit;
}

use App\Model\PackModel;
use App\Model\VideoModel;

$packModel = new PackModel();
$videoModel = new VideoModel();

$pack = $packModel->getPackById($_GET['id']);

$videos = $videoModel->getVideosByPack($_GET['id']);

// Edit pack
if(isset($_POST['edit-pack'])) {
    $pack_title = $_POST['pack-title'];
    $price = $_POST['price'];
    $image = $_POST['image'];
    $value_image = $_POST['value-image'];
    $description = $_POST['description'];
    $pack_errors = [];
    
    if(empty($pack_title)) {
        $pack_errors['title'] = 'Le champ <b>Titre</b> est vide';
    }
    if(empty($price)) {
        $pack_errors['price'] = 'Le champ <b>Prix</b> est vide';
    }
    // if(empty($description)) {
    //     $pack_errors['description'] = 'Le champ <b>Description</b> est vide';
    // }

    if(empty($pack_errors)) {

        if(!empty($image)) {
            $packModel->editPack($_GET['id'], $pack_title, $price, $image, $description);
            header('Location: ' . $_SERVER['REQUEST_URI']);
            exit;
        } else {
            $packModel->editPack($_GET['id'], $pack_title, $price, $value_image, $description);
            header('Location: ' . $_SERVER['REQUEST_URI']);
            exit;
        }
    }
}

// Edit video
if(!empty($videos)) {
    foreach($videos as $video) {
        if(isset($_POST['edit-'.$video['id']])) {

            if(empty($_POST['video-filename-'.$video['id']])) {
                $videoModel->editVideo($_GET['id'], $_POST['video-title-'.$video['id']], $_POST['value-filename-'.$video['id']], $_POST['rank-order-'.$video['id']], $video['id']);
                header('Location: ' . $_SERVER['REQUEST_URI']);
                exit;
            } else {
                $videoModel->editVideo($_GET['id'], $_POST['video-title-'.$video['id']], $_POST['video-filename-'.$video['id']], $_POST['rank-order-'.$video['id']], $video['id']);
                header('Location: ' . $_SERVER['REQUEST_URI']);
                exit;
            }
        }
    }
}

// Delete video
if(!empty($videos)) {
    foreach($videos as $video) {
        if(isset($_POST['delete-'.$video['id']])) {
            $videoModel->deleteVideo($video['id']);
        header('Location: ' . $_SERVER['REQUEST_URI']);
        exit;
        }
    }
}

// Add video to a pack
if(isset($_POST['add-video'])) {
    $video_title = $_POST['video-title'];
    $video_filename = $_POST['video-filename'];
    $rank_order = $_POST['rank-order'];
    $video_errors = [];

    if(empty($video_title)) {
        $video_errors['title'] = 'Vous devez choisir un titre';
    }
    if(empty($video_filename)) {
        $video_errors['filename'] = 'Vous devez choisir un fichier vidéo';
    }
    if(empty($rank_order)) {
        $video_errors['rank_order'] = 'Vous devez choisir un ordre';
    }

    if(empty($video_errors)) {
        $videoModel->addVideo($_GET['id'], $video_title, $video_filename, $rank_order);
        header('Location: ' . $_SERVER['REQUEST_URI']);
        exit;
    }
}

// Delete the pack
if(isset($_POST['delete-pack'])) {
    $packModel->deletePack($_GET['id']);
    header('Location: ' . constructUrl('admin'));
    exit;
}

$template = 'admin/editPack';
include '../templates/base.phtml';