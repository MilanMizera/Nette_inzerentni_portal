<?php

declare(strict_types=1);

namespace App\Presenters;


use App\model\MyAuthenticator;
use Nette;
use Nette\Application\UI\Form;


class LoginPresenter extends Nette\Application\UI\Presenter
{

	public function __construct(
		private MyAuthenticator $myAuthenticator,
	) {
	}


	public function actionSignIn()
	{

		$this->setLayout('private.user.layout');

	}



	public function actionDashboard()
	{



	}

	public function SignOut()
	{




	}




	protected function createComponentLoginForm(): Form
	{
		$form = new Form;
		$form->addEmail('email', 'Email:');
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


		try {

			$this->getUser()->login($data->email, $data->password);

		} catch (Nette\Security\AuthenticationException $e) {

            $this->flashMessage('Neplatné přihlašovací údaje', 'danger');
			$this->redirect('Login:login');

		}




		$this->flashMessage('Byl jste úspěšně přihlášen.');
		$this->redirect('Home:default');
	}
}
