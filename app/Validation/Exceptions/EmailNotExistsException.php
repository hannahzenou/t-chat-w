<?php

namespace Validation\Exceptions;

use Respect\Validation\Exceptions\ValidationException;

class EmailNotExistsException extends ValidationException
{
	public static $defaultTemplates = array(
		self::MODE_DEFAULT => [
			'L\'email existe déjà'
			],

		self::MODE_NEGATIVE => [
			'L\'email existe déjà'
			]
	);
}
