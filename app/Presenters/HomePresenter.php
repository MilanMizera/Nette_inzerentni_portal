<?php

declare(strict_types=1);

namespace App\Presenters;

use Nette;


final class HomePresenter extends Nette\Application\UI\Presenter
{


    public function renderDefault()
    {


        $this->template->userName = $this->getUser()->getIdentity()->name;
    }
}
