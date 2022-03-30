<?php

/**
 * LarpManager - A Live Action Role Playing Manager
 * Copyright (C) 2016 Kevin Polez
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace LarpManager\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * LarpManager\Repository\GeoPictoRepository
 *  
 * @author Tylia
 */
class GeoPictoRepository extends EntityRepository
{
	/**
	 * Fourni la liste des pictos du type demandé
	 * @return \Doctrine\Common\Collections\Collection
	 */
	public function findByType($type)
	{
		$pictos = $this->getEntityManager()
                ->createQuery("SELECT p FROM LarpManager\Entities\GeoPicto p WHERE p.type='".$type."'")
                ->getResult();
	
		return $pictos;
	}
}
