<?php
namespace App\Controllers;

class Pages extends BaseController {
    public function about(){
        // Set css and javascript
        $data = [
            'css' => array('about.css'),
            'js' => array('about.js'),
        ];

        // Show views
        echo view('templates/header', $data);
        echo view('about', $data);
        echo view('templates/footer', $data);
    }
}