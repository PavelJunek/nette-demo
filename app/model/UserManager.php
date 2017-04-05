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

namespace App\Model;

use Nette\Security\AuthenticationException;
use Nette\Security\IAuthenticator;
use Nette\Security\Identity;
use Nette\Security\Passwords;
use Nette\SmartObject;

/**
 * Správce uživatelů.
 *
 * Třída slouží současně jako autentifikátor, takže poskytuje metodu pro ověření
 * přihlašovacích údajů uživatele.
 *
 * @author Pavel Junek
 */
class UserManager implements IAuthenticator
{

	use SmartObject;

	/**
	 * @var Orm
	 */
	private $orm;

	/**
	 * @param Orm $orm
	 */
	public function __construct(Orm $orm)
	{
		$this->orm = $orm;
	}

	/**
	 * Ověří uživatelské jméno a heslo a vrátí identitu uživatele.
	 * Pokud jméno nebo heslo není plané, vyhodí výjimku.
	 *
	 * @param array $credentials
	 * @return Identity
	 * @throws AuthenticationException
	 */
	public function authenticate(array $credentials)
	{
		list($username, $password) = $credentials;

		// Načte uživatele z databáze
		$user = $this->orm->users->getBy(['username' => $username]);
		if (!$user) {
			throw new AuthenticationException('Neplatné uživatelské jméno', IAuthenticator::IDENTITY_NOT_FOUND);
		}

		// Ověří heslo uživatele
		if (!Passwords::verify($password, $user->passwordHash)) {
			throw new AuthenticationException('Neplatné heslo', IAuthenticator::INVALID_CREDENTIAL);
		}

		// Vytvoří identitu uživatele
		return new Identity($user->id);
	}

}
