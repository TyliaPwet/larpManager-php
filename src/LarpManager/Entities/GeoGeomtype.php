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
 * Created by Tylia
 */

namespace LarpManager\Entities;

use LarpManager\Entities\BaseGeoGeomtype;

/**
 * LarpManager\Entities\GeoGeomtype
 *
 * @Entity()
 */
class GeoGeomtype extends BaseGeoGeomtype
{
	public function __construct()
	{
		parent::__construct();
	}
	
	/*
	 * Serializer
	 */
	public function	jsonSerialize() {
		return array (
			'id' => $this->getId(),
			'categ' => $this->getCateg()->getCode(),
			'ordre'=> $this->getOrdre(),
			'zmin' => $this->getZmin(),
			'zmax' => $this->getZmax(),
			'style' => $this->getStylejson(),
			'geomtype' => $this->getCateg()->getGeomtype()->getCode()/*,
			'geomTranslate' => $this->getCateg()->getGeomtype()->getGtranslate(),
			'geomModify' => $this->getCateg()->getGeomtype()->getGmodify(),
			'terrModify' => $this->getCateg()->getGeomtype()->getTerritoiremodify(),
			'propsModify' => $this->getCateg()->getGeomtype()->getpropoertiesmodify()*/
		);
	}
}
