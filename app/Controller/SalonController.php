<?php

namespace Controller;

use Model\SalonsModel;
use Model\MessagesModel;

class SalonController extends BaseController
{

	/**
	* Cette méthode permet de voir la liste des messages d'un salon (son contenu)
	* param : $id, l'id du salon dont je cherche à voir les messages
	*/
	public function seeSalon($id) {

		/**
		* On instancie le modèle des salons de façon à récupérer les infos du salons (son nom) par son id ($id) passé en URL grace à la méthode find() du model dans W
		*/
		$salonsModel = new SalonsModel();
		$salon = $salonsModel->find($id);

		/**
		* On utilise une méthode propre au modèle MessagesModel qui permet de récupérer les messages avec les infos utilisateurs associées
		*/
		$messagesModel = new MessagesModel();
		$messages = $messagesModel-> searchAllWithUserInfos($id);

		$this->show('salons/see', array('salon' => $salon, 'messages' => $messages));
	}

}