<?php

namespace App\Controller;

use App\Core\AbstractController;
use App\Model\UserModel;
use App\Model\PackModel;
use App\Model\VideoModel;

class MemberController extends AbstractController {

    public function __construct()
    {
        // Need to be logged to access these pages
        if (!isset($_SESSION['user'])) {
            http_response_code(404);
            echo 'Erreur 404 : Page introuvable';
            exit;
        }
    }

    public function showPacks()
    { 
        $userModel = new UserModel();

        // Show user's pack(s)
        $userPacks = $userModel->getUserPacks($_SESSION['user']['id']);

        return $this->render('member', [
            'userPacks' => $userPacks
        ]);
    }

    public function showPackVideos()
    {
        $userModel = new UserModel();
        $packModel = new PackModel();
        $videoModel = new VideoModel();

        // Verify if url corresponds to an existing pack
        if (!array_key_exists('id', $_GET) || $packModel->verifyPackExists($_GET['id']) != true) {
            http_response_code(404);
            echo 'Erreur 404 : Page introuvable';
            exit;
        }

        // Verify if user get the pack
        if ($userModel->verifyUserGetPack($_SESSION['user']['id'], $_GET['id']) == false) {
            http_response_code(404);
            echo 'Erreur 404 : Page introuvable';
            exit;
        }
        
        // To show the title pack
        $pack = $packModel->getPackById($_GET['id']);

        // Show the pack'video(s)
        $videos = $videoModel->getVideosByPack($_GET['id']);

        return $this->render('pack', [
            'pack' => $pack,
            'videos' => $videos
        ]);
    }
}