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

use Nextras\Orm\Model\Model;

/**
 * Třída obsahující celý datový model aplikace.
 * Obsahuje především odkazy na úložiště jednotlivých tříd objektů.
 *
 * @property-read PostRepository $posts
 * @property-read TagRepository $tags
 *
 * @author Pavel Junek
 */
class Orm extends Model
{

}
