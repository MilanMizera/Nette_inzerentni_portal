<?php

namespace App\model;

use Nette;
use Nette\Security\SimpleIdentity;

class MyAuthenticator implements Nette\Security\Authenticator
{
	public function __construct(
		private Nette\Database\Explorer $database,
		private Nette\Security\Passwords $passwords,
	) {
	}

	public function authenticate(string $email, string $password): SimpleIdentity
	{
		$user = $this->database->table('users')
			->where('email', $email)
			->fetch();

		if ($user === null) {
			throw new Nette\Security\AuthenticationException('Uživatelská data neexistují.');
		}

		if ($this->passwords->verify($password, $user->password) === false) {
			throw new Nette\Security\AuthenticationException('Neplatné heslo.');
		}

		return new SimpleIdentity(
			$user->id,
			$user->role, // nebo pole více rolí
			['name' => $user->name],
		);
	}
}
