<?php

namespace LarpManager;

use Silex\Application;
use Silex\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * LarpManager\ReligionControllerProvider
 * 
 * @author kevin
 *
 */
class ReligionControllerProvider implements ControllerProviderInterface
{
	/**
	 * Initialise les routes pour les religions
	 * Routes :
	 * 	- religion
	 *  - religion.list
	 * 	- religion.add
	 *  - religion.update
	 *  - religion.detail
	 *  - religion.level
	 *  - religion.level.add
	 *  - religion.level.update
	 *  - religion.level.detail
	 *
	 * @param Application $app
	 * @return Controllers $controllers
	 */
	public function connect(Application $app)
	{
		$controllers = $app['controllers_factory'];

		/**
		 * Vérifie que l'utilisateur dispose du role CARTOGRAPHE
		 */
		$mustBeCartographe = function(Request $request) use ($app) {
			if (!$app['security.authorization_checker']->isGranted('ROLE_CARTOGRAPHE')) {
				throw new AccessDeniedException();
			}
		};
		
		/**
		 * Vérifie que l'utilisateur dispose du role SCENARISTE
		 */
		$mustBeOrga = function(Request $request) use ($app) {
			if (!$app['security.authorization_checker']->isGranted('ROLE_SCENARISTE')) {
				throw new AccessDeniedException();
			}
		};
		
		/**
		 * Liste des religions
		 */
		$controllers->match('/','LarpManager\Controllers\ReligionController::indexAction')
			->bind("religion")
			->method('GET')
			->before($mustBeCartographe);
		
		/**
		 * Ajout d'une religion
		 */
		$controllers->match('/add','LarpManager\Controllers\ReligionController::addAction')
			->bind("religion.add")
			->method('GET|POST')
			->before($mustBeOrga);
			
		/**
		 * Liste des adresse mail des joueurs ayant cette religion
		 */
		$controllers->match('/mail','LarpManager\Controllers\ReligionController::mailAction')
			->bind("religion.mail")
			->method('GET')
			->before($mustBeOrga);
		
		/**
		 * Liste des religions (joueur)
		 */
		$controllers->match('/list','LarpManager\Controllers\ReligionController::listAction')
			->bind("religion.list")
			->method('GET');
		
		/**
		 * Liste des personnages ayant cette religion
		 */			
		$controllers->match('/{religion}/perso','LarpManager\Controllers\ReligionController::persoAction')
			->bind("religion.perso")
			->method('GET')
			->convert('religion', 'converter.religion:convert')
			->before($mustBeOrga);
		
		/**
		 * Mise à jour d'une religion
		 */
		$controllers->match('/{index}/update','LarpManager\Controllers\ReligionController::updateAction')
			->assert('index', '\d+')
			->bind("religion.update")
			->method('GET|POST')
			->before($mustBeCartographe);
		
		/**
		 * Mise à jour du blason d'une religion
		 */
		$controllers->match('/{religion}/update/blason','LarpManager\Controllers\ReligionController::updateBlasonAction')
			->assert('religion', '\d+')
			->bind("religion.update.blason")
			->convert('religion', 'converter.religion:convert')
			->method('GET|POST')
			->before($mustBeCartographe);			
		
		/**
		 * Detail d'une religion
		 */
		$controllers->match('/{index}','LarpManager\Controllers\ReligionController::detailAction')
			->assert('index', '\d+')
			->bind("religion.detail")
			->method('GET')
			->before($mustBeCartographe);
		
		/**
		 * Niveaux de ferveurs
		 */
		$controllers->match('/level','LarpManager\Controllers\ReligionController::levelIndexAction')
			->bind("religion.level")
			->method('GET')
			->before($mustBeOrga);
		
		/**
		 * Ajouter un niveau de ferveur
		 */
		$controllers->match('/level/add','LarpManager\Controllers\ReligionController::levelAddAction')
			->bind("religion.level.add")
			->method('GET|POST')
			->before($mustBeOrga);

		/**
		 * Mettre à jour un niveau de ferveur
		 */
		$controllers->match('/level/{index}/update','LarpManager\Controllers\ReligionController::levelUpdateAction')
			->assert('index', '\d+')
			->bind("religion.level.update")
			->method('GET|POST')
			->before($mustBeOrga);
		
		/**
		 * Détail d'un niveau de ferveur
		 */
		$controllers->match('/level/{index}','LarpManager\Controllers\ReligionController::levelDetailAction')
			->assert('index', '\d+')
			->bind("religion.level.detail")
			->method('GET')
			->before($mustBeOrga);
			
		return $controllers;
	}
}