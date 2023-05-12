<?php

namespace App\Controller\Admin;

use App\Model\PackModel;
use App\Model\VideoModel;

class AdminPackController {

    function editPack()
    {
        // Admin page
        if($_SESSION['user']['role'] !== 'admin') {
            http_response_code(404);
            echo 'Erreur 404 : Page introuvable';
            exit;
        }

        $packModel = new PackModel();
        $videoModel = new VideoModel();

        $pack = $packModel->getPackById($_GET['id']);

        $videos = $videoModel->getVideosByPack($_GET['id']);

        // Edit pack
        if(isset($_POST['edit-pack'])) {
            $pack_title = $_POST['pack-title'];
            $price = $_POST['price'];
            $image = $_FILES['image'];
            $actual_image = $_POST['actual-image'];
            $description = $_POST['description'];
            $pack_errors = [];
            
            if(empty($pack_title)) {
                $pack_errors['title'] = 'Le champ <b>Titre</b> est vide';
            }
            if(empty($price)) {
                $pack_errors['price'] = 'Le champ <b>Prix</b> est vide';
            }
        
            if(array_key_exists('image', $_FILES) && $image['error'] != UPLOAD_ERR_NO_FILE) {

                $filesize = filesize($image['tmp_name']);
                if($filesize > MAX_UPLOAD_SIZE_IMAGE) {
                    $pack_errors['image'] = 'Votre fichier ne doit pas excéder 1 Mo';
                }

                $allowedMimeTypes = ['image/jpeg', 'image/jpg', 'image/png'];
                $mimeType = mime_content_type($image['tmp_name']);

                if(!in_array($mimeType, $allowedMimeTypes)) {
                    $pack_errors['image'] = 'Type de fichier non autorisé';
                }
            } else {
                $image = null;
            }

            if(empty($pack_errors)) {

                if($image == null) {
                    $filename = $actual_image;
                } else {
                    $filename = uploadFileInFolder($image, 'images');
                    unlink('images/' . $actual_image);
                }

                $packModel->editPack($_GET['id'], $pack_title, $price, $filename, $description);
                header('Location: ' . $_SERVER['REQUEST_URI']);
                exit;
            }
        }

        // Edit video
        if(!empty($videos)) {
            foreach($videos as $video) {
                if(isset($_POST['edit-'.$video['id']])) {

                    if(empty($_POST['video-filename-'.$video['id']])) {
                        $videoModel->editVideo($_GET['id'], $_POST['video-title-'.$video['id']], $_POST['actual-filename-'.$video['id']], $_POST['rank-order-'.$video['id']], $video['id']);
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
                    unlink('videos/' . $_POST['actual-filename-' . $video['id']]);

                    header('Location: ' . $_SERVER['REQUEST_URI']);
                    exit;
                }
            }
        }

        // Add video to a pack
        if(isset($_POST['add-video'])) {
            $video_title = $_POST['video-title'];
            $video_filename = $_FILES['video-filename'];
            $rank_order = $_POST['rank-order'];
            $video_errors = [];

            if(empty($video_title)) {
                $video_errors['title'] = 'Vous devez choisir un titre';
            }
            if(empty($rank_order)) {
                $video_errors['rank_order'] = 'Vous devez choisir un ordre';
            }
            if(array_key_exists('video-filename', $_FILES) && $video_filename['error'] != UPLOAD_ERR_NO_FILE) {

                $filesize = filesize($video_filename['tmp_name']);
                if($filesize > MAX_UPLOAD_SIZE_VIDEO) {
                    $video_errors['filename'] = 'Votre fichier ne doit pas excéder 1 Go';
                }

                $allowedMimeTypes = ['video/mp4'];
                $mimeType = mime_content_type($video_filename['tmp_name']);

                if(!in_array($mimeType, $allowedMimeTypes)) {
                    $video_errors['filename'] = 'Type de fichier non autorisé';
                }
            } else {
                $video_errors['filename'] = 'Veuillez choisir un fichier vidéo';
            }

            if(empty($video_errors)) {
                $filename = uploadFileInFolder($video_filename, 'videos');
                $videoModel->addVideo($_GET['id'], $video_title, $filename, $rank_order);

                header('Location: ' . $_SERVER['REQUEST_URI']);
                exit;
            }
        }

        // Delete the pack
        if(isset($_POST['delete-pack'])) {
            $packModel->deletePack($_GET['id']);

            foreach($videos as $video) {
                unlink('videos/' . $video['filename']);
            }
            unlink('images/' . $pack->getImage());

            header('Location: ' . constructUrl('admin'));
            exit;
        }

        $template = 'admin/editPack';
        include '../templates/base.phtml';
    }
}