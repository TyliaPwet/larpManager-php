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
 * Version 2.1.6-dev (doctrine2-annotation) on 2015-09-22 16:18:28.
 * Goto https://github.com/johmue/mysql-workbench-schema-exporter for more
 * information.
 */

namespace LarpManager\Entities;

use LarpManager\Entities\BaseParticipant;

/**
 * LarpManager\Entities\Participant
 *
 * @Entity(repositoryClass="LarpManager\Repository\ParticipantRepository")
 */
class Participant extends BaseParticipant
{
	/**
	 * Constructeur
	 */
	public function __construct()
	{
		$this->setSubscriptionDate(new \Datetime('NOW'));
	}
	
	public function __toString()
	{
		return $this->getUser()->getDisplayName();
	}
	
	/**
	 * Verifie si le participant a répondu à cette question
	 */
	public function asAnswser(Question $q)
	{
		foreach( $this->getReponses() as $reponse)
		{
			if ( $reponse->getQuestion() == $q) return true;
		}
		return false;
	}
	
	/**
	 * Vérifie si le joueur est responsable du groupe
	 * @param Groupe $groupe
	 */
	public function isResponsable(Groupe $groupe)
	{
		foreach ( $groupe->getGroupeGns() as $session)
		{
			if ( $this->getGroupeGns()->contains($session)) return true;
		}
		return false;
	}
		
	/**
	 * Fourni la session de jeu auquel participe l'utilisateur
	 */
	public function getSession()
	{
		return $this->getGroupeGn();
	}
	
	/**
	 * Retire un participant d'un groupe
	 */
	public function setGroupeGnNull()
	{
		$this->setGroupeGn(null);
		return $this;
	}
	
	/**
	 * Retire un personnage du participant
	 */
	public function setPersonnageNull()
	{
		$this->setPersonnage(null);
		return $this;
	}
	
	public function getUserIdentity()
	{
		return $this->getUser()->getDisplayName() .' '. $this->getUser()->getEmail();
		
	}
	
	public function getBesoinValidationCi() 
  {
	   return $this->getGn()->getBesoinValidationCi() && $this->getValideCiLe() == null;
	}
	
	/**
	 * Retourne le groupe du groupe gn associé
	 */
	public function getGroupe() : \LarpManager\Entities\Groupe
  {
	    if ($this->getGroupeGn() != null)
	    {
	       return $this->getGroupeGn()->getGroupe();
	    }
	    return null;
	}
  
  /**
	 * Retourne true si le participant a un billet PNJ, false sinon
	 */
	public function isPnj() : bool
	{
	    if ($this->getBillet())
	    {
	        return $this->getBillet()->isPnj();
	    }
	    return false;
	}
	
}
