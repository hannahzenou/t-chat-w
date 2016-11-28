<?php

namespace Controller;

use \Model\utilisateursModel;

class UserController extends BaseController
{
	/**
	* Cette fonction sert à afficher la liste des utilisateurs
	*/
	public function listUsers() {

		// On instancie depuis la fonction du controller un model d'utilisateurs pour pouvoir accéder à la liste des utilisateurs
		$usersModel = new utilisateursModel();

		$userList = $usersModel->findAll();

		$this->show('users/list', array('listUsers' => $userList));
		// show prend en paramètre le chemin de la vue à afficher app/Views/users/list.php
		// et en deuxième un tableau avec le nom qui contiendra $userList dans la vue
		// On rend les données accessible dans la vue en attribuant un nom à la variable qui contient le tableau
	}

}