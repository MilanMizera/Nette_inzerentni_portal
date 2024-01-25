<?php

declare(strict_types=1);

namespace App\Presenters;

use Nette;
use Nette\Application\UI\Form;
use Nette\Security\Passwords;

class RegisterPresenter extends Nette\Application\UI\Presenter
{

	public function __construct(
		private Nette\Database\Explorer $database,
	) {
	}

	

	protected function createComponentRegistrationForm(): Form
	{
		$form = new Form;
		$form->addText('name', 'Jméno:')
			->setRequired('Zadejte prosím jméno');

		$form->addText('surname', 'Příjmení:')
			->setRequired('Zadejte prosím Příjmená');

		$form->addEmail('email', 'Email:')
			->setRequired('Zadejte prosím email');

		$form->addPassword('password', 'Heslo:')
			->setRequired('Zadejte prosím heslo');

		$sex = [
			'm' => 'muž',
			'f' => 'žena',
		];
		$form->addRadioList('gender', 'Pohlaví:', $sex)
		->setRequired('Zadejte prosím pohlaví');

		$form->addDate('birthdays', 'Narozen:')
			->setRequired('Zadejte prosím datum narození');

		$form->addCheckbox('agree', 'Souhlasím se zpracovaním osobních údajů')
			->setRequired('Je potřeba souhlasit se zpracovaním osobních údajů');

		$form->addSubmit('send', 'Registrovat');
		$form->onSuccess[] = [$this, 'formSucceeded'];
		return $form;
	}

	public function formSucceeded(Form $form, $data): void
	{
		// tady zpracujeme data odeslaná formulářem
		// $data->name obsahuje jméno
		// $data->password obsahuje heslo

		//zahešujeme heslo
		$passwords = new Passwords(PASSWORD_BCRYPT, ['cost' => 12]);
		$hashed_password = $passwords->hash($data->password);

		$this->database->table('users')->insert([

			'name' => $data->name,
			'surname' => $data->surname,
			'email' => $data->email,
			'password' => $hashed_password,
			'gender' => $data->gender,
			'birthdays' => $data->birthdays,

		]);

		$this->flashMessage('Byl jste úspěšně registrován.', 'info');
		$this->redirect('Login:login');
	}
}
