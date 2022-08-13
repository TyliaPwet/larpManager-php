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
 
namespace LarpManager\Services\Converter;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use LarpManager\Entities\GeoMap;
use LarpManager\Entities\GeoCateg;

/**
 * LarpManager\Services\Converter\MapmanagerConverter
 */
class MapmanagerConverter
{
	/**
	 * 
	 * @var EntityManager
	 */
    private $em;

    /**
     * Constructeur
     * 
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * Fournit une GeoMap à partir de son identifiant
     * 
     * @param unknown $id
     * @throws NotFoundHttpException
     * @return LarpManager\Entities\GeoMap
     */
    public function convertMap($id)
    {
    	$map = $this->em->find('\LarpManager\Entities\GeoMap',(int) $id);
    	
        if (null === $map) {
            throw new NotFoundHttpException(sprintf('La carte %d n\'existe pas', $id));
        }

        return $map;
    }
    
    /**
     * Fournit une GeoCateg à partir de son code
     * 
     * @param string $code
     * @throws NotFoundHttpException
     * @return LarpManager\Entities\GeoCateg
     */
    public function convertCateg($code)
    {
    	$categ = $this->em->getRepository('LarpManager\Entities\GeoCateg')
    			->findByCode($code);
    	
        if (null === $categ) {
            throw new NotFoundHttpException(sprintf('La categ %s n\'existe pas', $code));
        }

        return $categ[0];
    }
}
