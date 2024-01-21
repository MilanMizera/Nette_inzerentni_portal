<?php

declare(strict_types=1);

namespace App\Presenters;

use Nette;
use Nette\Application\UI\Form;

class RegisterPresenter extends Nette\Application\UI\Presenter
{
	protected function createComponentRegistrationForm(): Form
	{
		$form = new Form;
		$form->addText('name', 'Jméno:');
		$form->addPassword('password', 'Heslo:');
		$form->addSubmit('send', 'Registrovat');
		$form->onSuccess[] = [$this, 'formSucceeded'];
		return $form;
	}

	public function formSucceeded(Form $form, $data): void
	{
		// tady zpracujeme data odeslaná formulářem
		// $data->name obsahuje jméno
		// $data->password obsahuje heslo
		$this->flashMessage('Byl jste úspěšně registrován.');
		$this->redirect('Home:');
	}
}
