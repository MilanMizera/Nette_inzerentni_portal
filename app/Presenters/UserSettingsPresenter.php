<?php

declare(strict_types=1);

namespace App\Presenters;

use Nette;
use Nette\Application\UI\Form;
use App\Model\UserSettings;
use Nette\Security\Passwords;



class UserSettingsPresenter extends Nette\Application\UI\Presenter
{
    public function __construct(
        private Nette\Database\Explorer $database,
        private UserSettings $userSettings,
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

        $form->addPassword('new1Password', 'Nové heslo:')
            ->addRule($form::MinLength, 'Heslo musí mít alespoň %d znaků', 8)
            ->addRule($form::Pattern, ' Heslo musí obsahovat číslici', '.*[0-9].*')
            ->addRule($form::Pattern, 'Heslo musí obsahovat velké písmeno', '.*[A-Z].*');

        $form->addPassword('new2Password', 'Nové heslo:')
            ->addRule($form::MinLength, 'Heslo musí mít alespoň %d znaků', 8)
            ->addRule($form::Pattern, ' Heslo musí obsahovat číslici', '.*[0-9].*')
            ->addRule($form::Pattern, 'Heslo musí obsahovat velké písmeno', '.*[A-Z].*');


        $form->addUpload('cv', 'životopis:')
            ->addRule($form::MaxFileSize, 'Maximální velikost je 1 MB.', 1024 * 1024);


        $form->addSubmit('send', 'Odeslat')
        ->setHtmlAttribute('id', 'btn_user_settings')
        ;
        $form->onSuccess[] = [$this, 'formSucceeded'];
        return $form;
    }

    public function formSucceeded(Form $form, $data): void
    {

        var_dump($data->name);
        var_dump($data->surname);
        var_dump($data->new1Password);

        $dbPassword = $this->database->table('users')
            ->where('id', $this->user->getIdentity()->getId())
            ->fetch();

        // tato metoda ovběřuje jestli zadané heslo od uživatele u inputu souhlasí s heslem v databázi, které je zahešované
        if (password_verify($data->oldPassword, $dbPassword->password) and $data->new1Password === $data->new2Password) {

            var_dump($data->new1Password);
            $passwords = new Passwords(PASSWORD_BCRYPT, ['cost' => 12]);
            $hashed_password = $passwords->hash($data->new1Password);

            $this->userSettings->changePassword($hashed_password);
            $this->flashMessage("Heslo bylo úspěšně změněno");
        }


        $this->userSettings->changeUserData($data->name, $data->surname);
    }
}
