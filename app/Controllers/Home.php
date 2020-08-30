<?php namespace App\Controllers;

use App\Models\Ammo;

class Home extends BaseController
{
	public function index()
	{
	    // Collect calibers for ammo buttons
		$ammo = new Ammo();
		$data['calibers'] = $ammo->getCalibers();

		// Set css and js links
		$data['css'] = array(
			'index.css'
		);
		$data['js'] = array(
			'index.js'
		);

		//Show views
		echo view('templates/header', $data);
		echo view('index', $data);
		echo view('templates/footer', $data);
	}

	//--------------------------------------------------------------------

}
