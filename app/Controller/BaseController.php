<?php

namespace Controller;

use \W\Controller\Controller;
use \Model\SalonsModel;
use \Plasticbrain\FlashMessages\FlashMessages;

class BaseController extends Controller
{
	/*
	* Ce champ va contenir l'engine de Plates qui va servir à afficher mes vues
	*/
	protected $engine;

	
	/*
	* Ce champ va contenir une instance de flash messenger de php-flash-messages
	*/
	protected $fmsg;

	public function __construct() {
		
		// On stocke dans la variable de classe engine une instance de league\Plates\engine alors que cette instance était créee directement dans la méthode show() de Controller
		$this->engine = new \League\Plates\Engine(self::PATH_VIEWS);

		$this->engine->loadExtension(new \W\View\Plates\PlatesExtensions());

		$app = getApp();

		$salonsModel = new SalonsModel();

		$this->fmsg = new FlashMessages(); // en l'instanciant dans le constructeur on pourra utiliser fmsg direct sans instancier l'objet a chaque fois

		$this->engine->addData(
			[
				'w_user' 		  => $this->getUser(),
				'w_current_route' => $app->getCurrentRoute(),
				'w_site_name'	  => $app->getConfig('site_name'),
				'salons'	  	  => $salonsModel->findall(),
				'fmsg'			  => $this->getFlashMessenger()
			]
		);

	}

	public function show($file, array $data = array()) {

		$file = str_replace('.php', '', $file);

		
		echo $this->engine->render($file, $data);
		die();
	}

	/*
	* Cette fonction sert à ajouter des données qui seront disponibles dans toute les vues fabriquées par $this->engine (donc par le BaseController)
	* Par exemple pour ajouter une liste d'utilisateurs à mes vues, on utilise $this->addGlobalData(array('users' => $users))
	*/
	public function addGlobalData(array $datas) {
		$this->engine->addData($datas);
	}

	/*
	* Retourne une instance du flash messenger de php-flash-messages
	*/
	public function getFlashMessenger() {
		return $this->fmsg;
	}
}