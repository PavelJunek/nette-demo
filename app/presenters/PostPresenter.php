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
use Nette\Http\Response;
use Nette\Utils\ArrayHash;
use Nette\Utils\DateTime;

/**
 * Presenter pro editaci článků.
 *
 * @author Pavel Junek
 */
class PostPresenter extends BasePresenter
{

	/**
	 * Metoda volaná při startu.
	 * Zkontroluje, zda je uživatel přihlášen, jinak ohlásí chybu.
	 */
	protected function startup()
	{
		parent::startup();

		if (!$this->getUser()->isLoggedIn()) {
			$this->error('Pro tuto operaci musíte být přihlášen', Response::S403_FORBIDDEN);
		}
	}

	/**
	 * Zobrazí stránku s editačním formulářem.
	 *
	 * @param int $id
	 */
	public function renderEdit($id)
	{
		// Načte článek z databáze
		$post = $this->orm->posts->getById($id);
		if (!$post) {
			$this->error('Článek nenalezen', Response::S404_NOT_FOUND);
		}

		// Vytvoří formulář
		$form = $this->getComponent('editForm');

		// Naplní formulář počátečními hodnotami
		$form->setDefaults([
			'id' => $post->id,
			'title' => $post->title,
			'date' => $post->date,
			'body' => $post->body,
		]);

		// Předá článek do šablony
		$this->template->post = $post;
	}

	/**
	 * Vytvoří editační formulář.
	 *
	 * @return Form
	 */
	protected function createComponentEditForm()
	{
		$form = new Form();

		$form->addProtection();
		$form->addHidden('id');
		$form->addText('title', 'Nadpis')
				->addRule(Form::FILLED);
		$form->addDatePicker('date', 'Datum vytvoření')
				->addRule(Form::FILLED)
				->addRule(Form::RANGE, 'Datum je mimo rozsah', [DateTime::from('2017-01-01'), DateTime::from('now')]);
		$form->addTextArea('body', 'Text příspěvku')
				->addRule(Form::FILLED);
		$form->addSubmit('send', 'Uložit');

		$form->onSuccess[] = [$this, 'onEditFormSubmitted'];

		return $form;
	}

	/**
	 * Metoda volaná po přijetí dat z formuláře.
	 * Změní článek a uloží ho do databáze.
	 *
	 * @param Form $form
	 * @param ArrayHash $values
	 */
	public function onEditFormSubmitted($form, $values)
	{
		// Načte článek z databáze
		$post = $this->orm->posts->getById($values->id);
		if (!$post) {
			$this->error('Neplatná data');
		}

		// Změní hodnoty
		$post->title = $values->title;
		$post->date = $values->date;
		$post->body = $values->body;

		// Uloží článek do databáze
		$this->orm->persistAndFlush($post);

		// Přesměruje na úvodní stránku
		$this->flashMessage('Článek byl uložen.');
		$this->redirect('Homepage:');
	}

}
