<?php

namespace App\Model;

use Nette;

class UserSettings
{
    public function __construct(
        private Nette\Database\Explorer $database,
        private Nette\Security\User $user,
    ) {
    }

    public function changeUserData(string $name, string $surname, )
    {

        $this->database->table('users')
            ->where('id', $this->user->getIdentity()->getId())
            ->update([

                'name' => $name,
                'surname' => $surname,

            ]);

    }


    public function changePassword($newPassword)
    {
        $this->database->table('users')
            ->where('id', $this->user->getIdentity()->getId())
            ->update([
                'password' => $newPassword

            ]);
    }

}