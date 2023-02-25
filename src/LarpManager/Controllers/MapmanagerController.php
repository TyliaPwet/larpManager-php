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

namespace LarpManager\Controllers;

use Symfony\Component\HttpFoundation\Request;
use Silex\Application;

use LarpManager\Entities\GeoMap;
use LarpManager\Entities\GeoCateg;
use LarpManager\Entities\GeoObj;
use LarpManager\Entities\GeoLayer;


/**
 * LarpManager\Controllers\MapmanagerController
 *
 * @author Tylia
 *
 */
class MapmanagerController
{

	/**
	 * Liste des cartes
	 *
	 * @param Request $request
	 * @param Application $app
	 */
	public function indexAction(Request $request, Application $app)
	{
		$maps = $app['orm.em']->getRepository('LarpManager\Entities\GeoMap')->findAll();
	
		return $app['twig']->render('admin\mapmanager\index.twig', array(
			'maps' => $maps
		));
	}

	public function detailAction(Request $request, Application $app, GeoMap $geomap)
	{		
		return $app['twig']->render('admin\mapmanager\map.twig', array(
				'geomap' => $geomap
		));
	}
/*	
	public function gestionAction(Request $request, Application $app, GeoMap $geomap)
	{	
		$layers = $geomap->getLayers();
					
		return $app['twig']->render('admin\mapmanager\mapmodif.twig', array(
				'geomap' => $geomap,
				'layers' => $layers
		));
	}
	*/
	public function testAction(Request $request, Application $app, GeoMap $geomap)
	{	
				
		return $app['twig']->render('admin\mapmanager\test.twig', array(
				'geomap' => $geomap
		));
	}
	
	
	/**
	 * Config d'une carte
	 * 
	 * @param Request $request
	 * @param Application $app
	 */
	public function getConfig(Request $request, Application $app, GeoMap $geomap)
	{
		$geomapjson = $geomap->jsonSerialize();
		$config['map'] = $geomapjson;

		$config['layers'] = [];
		$layers = $geomap->getLayers();
		
		foreach ($layers as $layer) {
			$config['layers'][] = $layer->jsonSerialize();
		}
		
		return $app->json($config); 
	}
	
	/**
	 * Affiche une carte du monde
	 *
	 * @param Request $request
	 * @param Application $app
	 *//*
	public function worldmapAction(Request $request, Application $app)
	{
		return $app['twig']->render('admin/mapmanager/worldmap.twig');
	}
*/
	/**
	 * Fournit la liste des features selon la catégorie demandée
	 *
	 * @param Request $request
	 * @param Application $app
	 */			
	public function getFeatures(Request $request, Application $app, GeoCateg $categ)
	{	
		$objs = $app['orm.em']->getRepository('LarpManager\Entities\GeoObj')->findByCateg($categ->getId());

		$features = array();
		foreach ( $objs as $feat)
		{
			$features[] = $feat->jsonSerialize();
		}
		
		return $app->json($features);
	}
	
	/**
	 * Met à jour la feature demandée
	 *
	 * @param Request $request
	 * @param Application $app
	 */			
	public function updateFeatures(Request $request, Application $app)
	{
		$categ = $request->get('categ');
		$id = $request->get('id');		

		$fields = ['geom'=>'setGeojson', 'properties'=>'setPropertiesjson'];
	
		$repo = 'LarpManager\Entities\GeoObj';
		$row = $app['orm.em']->find($repo, $id);
		
		$res = ["id" => $id, "categ" => $categ];
					
		foreach ($fields as $nom => $fonction) {
			if ($request->get($nom) !== null) {
				$row->$fonction($request->get($nom));
				$res[$nom] = $request->get($nom);
			}
		}

		$app['orm.em']->persist($row);
		$app['orm.em']->flush();
		
		return $app->json($res); 
	}
	
	
	/**
	 * Crée une nouvelle feature
	 *
	 * @param Request $request
	 * @param Application $app
	 */			
	public function addFeatures(Request $request, Application $app)
	{
		$categCode = $request->get('categ');
		$categObj = $app['orm.em']->getRepository('LarpManager\Entities\GeoCateg')->findByCode($categCode);
						
		$row = new GeoObj();
		$row->setCateg($categObj[0]);
		$row->setGeoJson($request->get('geom'));
		if ($request->get('properties') !== null) {
			$row->setPropertiesjson($request->get('properties'));
		}
								
		$app['orm.em']->persist($row);
		$app['orm.em']->flush();
		
		$res['id'] = $row->getId();

		return $app->json($res); 
	}
	
	
	/*
	public function indexCategsAction(Request $request, Application $app)
	{
		$categs = $app['orm.em']->getRepository('LarpManager\Entities\GeoCateg')->findAll();
	
		return $app['twig']->render('admin\mapmanager\indexcategs.twig', array(
			'categs' => $categs
		));
	}
	*/
	/**
	 * Détail d'une carte
	 * 
	 * @param Request $request
	 * @param Application $app
	 */
	 /*
	public function detailCategAction(Request $request, Application $app, GeoCateg $categ)
	{	
		$objs = $app['orm.em']->getRepository('LarpManager\Entities\GeoObj')->findByCateg($categ->getId());
			
		return $app['twig']->render('admin\mapmanager\detailcateg.twig', array(
				'categ' => $categ,
				'objs' => $objs
		));
	}
	*/
}
