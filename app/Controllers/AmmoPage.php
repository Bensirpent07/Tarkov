<?php


namespace App\Controllers;

use App\Models\Ammo;

class AmmoPage extends BaseController
{
    public function index($filter = 'none'){

        //Get ammo filter options;
        $ammoModel = new Ammo();

        //Set css and js links. Set filter if it is given
        $data = [
            'css' => array('ammo.css'),
            'js' => array('ammo.js'),
            'filter' => $filter,
            'ammoCalibers' => $ammoModel->getCalibers()
        ];

        //Show views
        echo view('templates/header', $data);
        echo view('ammo', $data);
        echo view('templates/footer', $data);
    }

    public function fetch_ammo_chart(){
        //Check if AJAX
        if(!$this->request->isAJAX()){
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        else{
            //Load Model
            $ammoModel = new Ammo();

            //Get ammo list
            echo json_encode($ammoModel->get_ammo_list());
        }
    }
}