<?php

namespace Controller;

use \Model\UtilisateursModel;
use W\security\AuthentificationModel;

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

	public function login() {

		// Vérif de la non vacuité du POST, cad qu'un formulaire a bien été envoyé
		if(!empty($_POST)) {

			// Vérif de la non vacuité du pseudo en POST
			if(empty($_POST['pseudo'])) {
				// Si le pseudo est vide ou inexistant on ajoute un message d'erreur
				$this->getFlashMessenger()->error('Veuillez entrer un pseudo');
			}

			// Vérif de la non vacuité du mot de passe en POST
			if(empty($_POST['mot_de_passe'])) {
				// Si le mot de passe est vide ou inexistant on ajoute un message d'erreur
				$this->getFlashMessenger()->error('Veuillez entrer un mot de passe');
			}
			
			$auth = new AuthentificationModel();

			if(! $this->getFlashMessenger()->hasErrors() ) {
				// Vérif de l'existance de l'utilisateur

				$idUser = $auth->isValidLoginInfo($_POST['pseudo'], $_POST['mot_de_passe']);

				// Si l'utilisateur existe bel et bien on récupère ses infos et on le log
				if($idUser !== 0) {

					$utilisateurModel = new UtilisateursModel();

					$userInfos = $utilisateurModel->find($iduser);

					$auth->logUserIn($userInfos);

					// Une fois l'utilisateur connecté on le redirige vers l'accueil
					$this->redirectToRoute('default_home');
				
				} else {
					// les infos de connexion sont incorrectes
					$this->getFlashMessenger()->error('Vos informations de connexion sont incorrectes');
				}
			}
		}

		// On vérifie qu'il y a un post et on le transmet à la vue
		$this->show('users/login', array('datas' => isset($_POST) ? $_POST : array() ));

		// $authentification = new AuthentificationModel();
		// $utilisateur = new UtilisateursModel();


		// if(!empty($_POST['pseudo']) && !empty($_POST['mot_de_passe'])) {

		// 	if( ($authentification->isValidLoginInfo($_POST['pseudo'], $_POST['mot_de_passe']) != 0) ) {

		// 		$user = $utilisateur->getUserByUsernameOrEmail($_POST['pseudo']);

		// 		$authentification->logUserIn($user);

		// 		$this->redirectToRoute('users_list');

		// 	} else {
		// 		echo 'Vous n\'etes pas encore inscrit !';
		// 	}
			
		// } else {
		// 	echo 'Mauvais pseudo ou mot de passe !';
		// }

		// $this->show('users/login');
	}


	public function logout() {

		$auth = new AuthentificationModel();

		$auth->logUserOut();
		
		$this->redirectToRoute('login');
	}


	public function register() {

		$this->show('users/register');
	}

}