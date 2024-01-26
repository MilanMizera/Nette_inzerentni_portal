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
		$row = $this->database->table('users')
			->where('email', $email)
			->fetch();

		if (!$row) {
			throw new Nette\Security\AuthenticationException('Uživatelská data neexistují.');
		}

		if (!$this->passwords->verify($password, $row->password)) {
			throw new Nette\Security\AuthenticationException('Neplatné heslo.');
		}

		return new SimpleIdentity(
			$row->id,
			//$row->role, // nebo pole více rolí
			['name' => $row->name],
		);
	}
}
