<?php

namespace Validation\Rules;

use Respect\Validation\Rules\AbstractRule;
use W\Model\UsersModel;

/*
* Cette classe sert à éténdre les fonctionalités de la bibliothèque respect/validation en y ajoutant un nouveau validateur
*/

class UserNameNotExists extends AbstractRule
{
	public function validate($pseudo) {
		$userModel = new UsersModel();
		return ! $userModel->UserNameExists($pseudo);
	}
}