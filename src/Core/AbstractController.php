<?php

namespace App\Core;

abstract class AbstractController {

    public function render(string $template, array $params = [])
    {
        ob_start();

        extract(cleanData($params));
        // extract($params);
        
        require '../templates/base.phtml';

        $html = ob_get_clean();

        return $html;
    }
}