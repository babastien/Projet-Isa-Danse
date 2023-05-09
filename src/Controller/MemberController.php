<?php

namespace App\Controller;

use App\Model\UserModel;
use App\Model\PackModel;
use App\Model\VideoModel;

class MemberController {

    public function __construct()
    {
        // Need to be logged to access these pages
        if(!isset($_SESSION['user'])) {
            http_response_code(404);
            echo 'Erreur 404 : Page introuvable';
            exit;
        }
    }

    function showPacks()
    { 
        $userModel = new UserModel();

        // Show user's pack(s)
        $userPacks = $userModel->getUserPacks($_SESSION['user']['id']);

        $template = 'member';
        include '../templates/base.phtml';
    }

    function showPackVideos()
    {
        $userModel = new UserModel();
        $packModel = new PackModel();
        $videoModel = new VideoModel();

        // Verify url/if the pack exists
        if(!array_key_exists('id', $_GET) || $packModel->verifyPackExists($_GET['id']) != true) {
            http_response_code(404);
            echo 'Erreur 404 : Page introuvable';
            exit;
        }

        // Verify if user get the pack
        if($userModel->verifyUserGetPack($_SESSION['user']['id'], $_GET['id']) == false) {
            http_response_code(404);
            echo 'Erreur 404 : Page introuvable';
            exit;

        } else {
            // To show the title pack
            $pack = $packModel->getPackById($_GET['id']);

            // Show the pack'video(s)
            $videos = $videoModel->getVideosByPack($_GET['id']);
        }

        $template = 'pack';
        include '../templates/base.phtml';
    }
}