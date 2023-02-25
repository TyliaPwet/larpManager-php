<?php

namespace LarpManager;

use Silex\Application;
use Silex\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;


/**
 * LarpManager\MapmanagerControllerProvider
 * 
 * @author Tylia
 *
 */
class MapmanagerControllerProvider implements ControllerProviderInterface
{
	/**
	 * Initialise les routes pour les cartes du monde 
	 * Routes :
	 * 	- mapmanager
	 * 	- mapmanager.add
	 *  - mapmanager.update
	 *  - mapmanager.delete
	 *
	 * @param Application $app
	 * @return Controllers $controllers
	 */
	public function connect(Application $app)
	{
		$controllers = $app['controllers_factory'];
		
		/**
		 * Vérifie que l'utilisateur dispose du role ADMIN
		 */
		/*$mustBeRegle = function(Request $request) use ($app) {
			if (!$app['security.authorization_checker']->isGranted('ROLE_ADMIN')) {
				throw new AccessDeniedException();
			}
		};
		*/
		$controllers->match('/','LarpManager\Controllers\MapmanagerController::indexAction')
			->bind("mapmanager")
			->method('GET');
		


					
		$controllers->match('/detail/{geomap}','LarpManager\Controllers\MapmanagerController::detailAction')
			->assert('geomap', '\d+')
			->convert('geomap', 'converter.mapmanager:convertMap')
			->bind("mapmanager.detail")
			->method('GET');

	/* page non fonctionnelle, à terminer ultérieurement
		$controllers->match('/gestion/{geomap}','LarpManager\Controllers\MapmanagerController::gestionAction')
			->assert('geomap', '\d+')
			->convert('geomap', 'converter.mapmanager:convertMap')
			->bind("mapmanager.gestion")
			->method('GET'); */
	
	/* page fonctionnelle mais gestion des menus en dur, à améliorer dans la page /gestion/ et supprimer celle-ci ensuite*/		
		$controllers->match('/test/{geomap}','LarpManager\Controllers\MapmanagerController::testAction')
			->assert('geomap', '\d+')
			->convert('geomap', 'converter.mapmanager:convertMap')
			->bind("mapmanager.test")
			->method('GET');
		
				
		
		
			
		$controllers->match('/config/get/{geomap}','LarpManager\Controllers\MapmanagerController::getConfig')
					->assert('geomap', '\d+')
					->convert('geomap', 'converter.mapmanager:convertMap')
					->method('GET')
					->bind('mapmanager.config.get');
			       					
		$controllers->match('/features/get/{categ}','LarpManager\Controllers\MapmanagerController::getFeatures')
					->convert('categ', 'converter.mapmanager:convertCateg')
					->method('GET')
					->bind('mapmanager.features.get');

		$controllers->match('/features/update','LarpManager\Controllers\MapmanagerController::updateFeatures')
					->method('POST')
					->bind('mapmanager.features.update');
	
		$controllers->match('/features/add','LarpManager\Controllers\MapmanagerController::addFeatures')
					->method('POST')
					->bind('mapmanager.features.add');
											
		return $controllers;
	}
}
