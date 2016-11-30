<?php

namespace Controller;

use \Model\UtilisateursModel;
use W\security\AuthentificationModel;
use Respect\Validation\Validator as v;
use Respect\Validation\Exceptions\NestedValidationException;

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

		if(!empty($_POST)) {
			// On indique à respect validation que nos règles de validation seront accessibles depuis le namespace Validation\Rules
			v::with("Validation\Rules");

			$validators = array(
				'pseudo' => v::length(3,50)
					->alnum()
					->noWhitespace()
					->userNameNotExists()
					->setName('Nom d\'utilisateur'),

				'email' => v::email()
					->emailNotExists()
					->setName('Email'),

				'mot_de_passe' => v::length(3,50)
					->alnum()
					->noWhitespace()
					->setName('Mot de passe'),

				'sexe' => v::in(array('femme', 'homme', 'non-defini')),

				'avatar' => v::optional(
					v::image()->size('1MB')
					->uploaded()
					)	
				);


			$datas = $_POST;

			// On ajoute le chemin vers le fichier d'avatar qui a été uploadé si il y en a un
			if(! empty($_FILES['avatar']['tmp_name'])) {
				// On stocke en données à valider le chemin vers la localisation temporaire de l'avatar
				$datas['avatar'] = $_FILES['avatar']['tmp_name'];
			} else {
				$datas['avatar'] = '';
			}

			// Je parcours la liste de mes validateurs  en récupérant aussi le nom du champ en clé
			foreach($validators as $field => $validator) {
				// La méthode assert renvoie une exception de type NestedValidationException qui nous permet de récupérer le ou les messages d'erreur en cas d'erreurs
				try {
					// On essaie de valider la donnée si une exception se produit, on exécute le bloc catch
					$validator->assert(isset($datas[$field]) ? $datas[$field] : '');

				} catch(NestedValidationException $ex) {
					// on récupère l'exception qui signifie qu'il y a eu une erreur et on ajoute un message d'erreur avec l'autre bibliotèque
					$fullMessage = $ex->getFullMessage();

					$this->getFlashMessenger()->error($fullMessage);

				}
				
			}

			if(! $this->getFlashMessenger()->hasErrors()) {
				
				// Si on a pas rencontré d'erreur on procède à l'insertion du nouvel utilisateur
				// Avant l'insertion on doit hasher le mot de passe grace à une méthoder du modèle authentification
				$auth = new AuthentificationModel();

				$datas['mot_de_passe'] = $auth->hashPassword($datas['mot_de_passe']);

				if(!empty($_FILES['avatar']['tmp_name'])) {
					// Ensuite on déplace l'avatar du fichier temporaire vers le dossier uploads
					$initialAvatarPath = $_FILES['avatar']['tmp_name'];

					$avatarNewName = md5(time(). uniqid());

					$targetPath = realpath('assets/uploads');
					// realpath est une fonction native php pour indiquer le chemin relatif à partir du dossier public qui est le répertoire de base
					
					move_uploaded_file($initialAvatarPath, $targetPath. '/' .$avatarNewName);

					// On met à jour le nouveau nom de l'avatar dans datas
					$datas['avatar'] = $avatarNewName;
				
				} else {
					$data['avatar'] = 'default.png';
				}

				// Insertion en base de données 
				$utilisateursModel = new utilisateursModel();

				unset($datas['send']);

				$userInfos = $utilisateursModel->insert($datas);

				$auth->logUserIn($userInfos);

				$this->getFlashMessenger()->success('Vous etes bien inscrit à TChat');

				$this->redirectToRoute('default_home');
			}
		}


		$this->show('users/register');
	}

}