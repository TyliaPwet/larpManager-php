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

/**
 * Auto generated by MySQL Workbench Schema Exporter.
 * Version 2.1.6-dev (doctrine2-annotation) on 2015-09-10 10:49:20.
 * Goto https://github.com/johmue/mysql-workbench-schema-exporter for more
 * information.
 */

namespace LarpManager\Entities;

use LarpManager\Entities\BaseSecondaryGroup;

/**
 * LarpManager\Entities\SecondaryGroup
 *
 * @Entity(repositoryClass="LarpManager\Repository\SecondaryGroupRepository")
 */
class SecondaryGroup extends BaseSecondaryGroup
{
	
	public function __toString()
	{
		return $this->getLabel();	
	}
	
	/**
	 * Fourni le personnage responsable du groupe
	 */
	public function getResponsable()
	{
		return $this->getPersonnage();
	}
	
	/**
	 * Défini le personnage responsable du groupe
	 * @param Personnage $personnage
	 */
	public function setResponsable(Personnage $personnage)
	{
		$this->setPersonnage($personnage);
		return $this;
	}
	
	/**
	 * Vérifie si un personnage est membre du groupe
	 * 
	 * @param Personnage $personnage
	 */
	public function isMembre(Personnage $personnage)
	{
		foreach ( $this->getMembres() as $membre)
		{
			if ( $membre->getPersonnage() == $personnage) return true;
		}
		return false;
	}
	
	/**
	 * Vérifie si un personnage est postulant à ce groupe
	 * 
	 * @param Personnage $personnage
	 */
	public function isPostulant(Personnage $personnage)
	{
		foreach ( $this->getPostulants() as $postulant)
		{
			if ( $postulant->getPersonnage() == $personnage) return true;
		}
		return false;
	}

	public function getActifs(Gn $gn)
	{
		$count_actifs = 0;
		foreach ($this->getMembres() as $membre)
		{
			$count_actifs += intval($membre->getPersonnage()->participeTo($gn));
		}
		return $count_actifs;
	}
}