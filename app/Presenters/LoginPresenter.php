<?php

declare(strict_types=1);

namespace App\Presenters;

use Nette;
use Nette\Application\UI\Form;

class LoginPresenter extends Nette\Application\UI\Presenter
{
	protected function createComponentLoginForm(): Form
	{
		$form = new Form;
		$form->addText('name', 'Jméno:');
		$form->addPassword('password', 'Heslo:');
		$form->addSubmit('send', 'Přihlásit se');
		$form->onSuccess[] = [$this, 'formSucceeded'];
		return $form;
	}

	public function formSucceeded(Form $form, $data): void
	{
		// tady zpracujeme data odeslaná formulářem
		// $data->name obsahuje jméno
		// $data->password obsahuje heslo
		$this->flashMessage('Byl jste úspěšně přihlášen.');
		$this->redirect('Home:default');
	}
}
