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

use Nette\Utils\Paginator;

/**
 * Presenter pro zobrazení článků.
 *
 * @author Pavel Junek
 */
class HomepagePresenter extends BasePresenter
{

	const POSTS_PER_PAGE = 2;

	/**
	 * Zobrazí úvodní stránku s výpisem všech článků.
	 *
	 * @param int|NULL $p
	 */
	public function renderDefault($p = NULL)
	{
		$posts = $this->orm->posts->findAll()->orderBy('date', 'DESC');

		$paginator = new Paginator();
		$paginator->setItemsPerPage(self::POSTS_PER_PAGE);
		$paginator->setItemCount($posts->countStored());
		$paginator->setPage($p ?: 1);

		$this->template->posts = $posts->limitBy($paginator->getLength(), $paginator->getOffset());
		$this->template->paginator = $paginator;
	}

}
