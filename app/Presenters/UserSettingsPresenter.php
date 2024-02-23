<?php

declare(strict_types=1);

namespace App\Presenters;

use Nette;
use Nette\Application\UI\Form;
use Nette\Security\SimpleIdentity;

class UserSettingsPresenter extends Nette\Application\UI\Presenter
{
    public function __construct(
        private Nette\Database\Explorer $database,
    ) {
    }

    protected function startup()
    {
        parent::startup();
        if (!$this->getUser()->isLoggedIn()) {
            $this->redirect('Login:login');
        }
    }


    protected function createComponentUserSettingsForm(): Form
    {

        $user = $this->database->table('users')
            ->where('id', $this->getUser()->getIdentity()->getId())
            ->fetch();


        $form = new Form;
        $form->addText('name', 'Jméno:')
            ->setDefaultValue($user->name);

        $form->addText('surname', 'Příjmení:')
            ->setDefaultValue($user->surname);

        $form->addText('gender', 'Pohlaví:')
            ->setDisabled()
            ->setDefaultValue($user->gender);


        $form->addDate('birthday', 'narození:')
            ->setDisabled()
            ->setDefaultValue($user->birthdays);

        $form->addPassword('oldPassword', 'Staré heslo:');

        $form->addPassword('newPassword', 'Nové heslo:')
            ->addRule($form::MinLength, 'Heslo musí mít alespoň %d znaků', 8)
            ->addRule($form::Pattern, ' Heslo musí obsahovat číslici', '.*[0-9].*')
            ->addRule($form::Pattern, 'Heslo musí obsahovat velké písmeno', '.*[A-Z].*');

        $form->addUpload('cv', 'životopis:')
            ->addRule($form::MaxFileSize, 'Maximální velikost je 1 MB.', 1024 * 1024);


        $form->addSubmit('send', 'Odeslat');
        $form->onSuccess[] = [$this, 'formSucceeded'];
        return $form;
    }

    public function formSucceeded(Form $form, $data): void
    {
        // tady zpracujeme data odeslaná formulářem
        // $data->name obsahuje jméno
        // $data->password obsahuje heslo
        $this->flashMessage('Vaše osobní údaje byly úspěšně změněny', "sucess");

    }
}




