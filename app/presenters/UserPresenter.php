<?php

/*
 * Copyright (C) 2016 Pavel Junek
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 */

namespace App\Presenters;

use Nette\Application\UI\Form;
use Nette\Security\AuthenticationException;
use Nette\Utils\ArrayHash;

/**
 * Presenter pro přihlašování a odhlašování uživatelů.
 *
 * Všimněte si, že tu není žádná metoda renderLogin(). Není totiž potřeba, byla
 * by prázdná. Úplně stačí, když existuje šablona login.latte, která se zobrazí.
 *
 * Není tu ani renderLogout(), protože pro odhlášení neexistuje žádná stránka,
 * která by se měla zobrazit. Po odhlášení dojde k přesměrování na homepage.
 * Takže je tu jenom actionLogout() - metoda, která se spouští dříve, než by
 * došlo k renderLogout(), a ta provede odhlášení a přesměrování.
 *
 * @author Pavel Junek
 */
class UserPresenter extends BasePresenter
{

	/**
	 * Odhlásí uživatele a přesměruje na úvodní stránku.
	 */
	public function actionLogout()
	{
		$this->getUser()->logout(TRUE);

		$this->flashMessage('Byl(a) jste odhlášen(a).');
		$this->redirect('Homepage:');
	}

	/**
	 * Vytvoří přihlašovací formulář.
	 *
	 * @return Form
	 */
	protected function createComponentLoginForm()
	{
		$form = new Form();

		$form->addProtection();
		$form->addText('username', 'Uživatelské jméno')
				->addRule(Form::FILLED);
		$form->addPassword('password', 'Heslo')
				->addRule(Form::FILLED);
		$form->addSubmit('send', 'Přihlásit');

		$form->onSuccess[] = [$this, 'onLoginFormSubmitted'];

		return $form;
	}

	/**
	 * Přihlásí uživatele a přesměruje na úvodní stránku.
	 *
	 * @param Form $form
	 * @param ArrayHash $values
	 */
	public function onLoginFormSubmitted($form, $values)
	{
		try {
			$this->getUser()->login($values->username, $values->password);
			$this->redirect('Homepage:');
		} catch (AuthenticationException $ex) {
			$form->addError($ex->getMessage());
		}
	}

}
