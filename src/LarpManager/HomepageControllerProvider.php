<?php

namespace LarpManager;

use Silex\Application;
use Silex\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;


/**
 * LarpManager\HomepageControllerProvider
 * 
 * @author kevin
 *
 */
class HomepageControllerProvider implements ControllerProviderInterface
{
	/**
	 * Initialise des routes non lié à un objet en particulier 
	 * Routes :
	 * 	- homepage
	 * 	- world
	 *  - inscription
	 *
	 * @param Application $app
	 * @return Controllers $controllers
	 */
	public function connect(Application $app)
	{
		$controllers = $app['controllers_factory'];
		
		/**
		 * Vérifie que l'utilisateur dispose du role SCENARISTE
		 */
		$mustBeScenariste = function(Request $request) use ($app) {
			if (!$app['security.authorization_checker']->isGranted('ROLE_SCENARISTE')) {
				throw new AccessDeniedException();
			}
		};
		
		$mustBeUser = function(Request $request) use ($app) {
			if ( ! $app['user'] ) {
				throw new AccessDeniedException();
			}
		};
		
		
		/** Affichage de la page d'acceuil */
		$controllers->match('/','LarpManager\Controllers\HomepageController::indexAction')
					->method('GET')
					->bind('homepage');
					
		/**
		 * Affichage de la premiere étape
		 */
		$controllers->match('/newUser/step1','LarpManager\Controllers\HomepageController::newUserStep1Action')
					->method('GET')
					->bind('newUser.step1')
					->before($mustBeUser);
					
		/**
		 * Affichage de la seconde étape
		 */
		$controllers->match('/newUser/step2','LarpManager\Controllers\HomepageController::newUserStep2Action')
					->method('GET|POST')
					->bind('newUser.step2')
					->before($mustBeUser);
					
		/**
		 * Affichage de la troisième étape
		 */
		$controllers->match('/newUser/step3','LarpManager\Controllers\HomepageController::newUserStep3Action')
					->method('GET|POST')
					->bind('newUser.step3')
					->before($mustBeUser);
					
		/**
		 * Affichage de la troisième étape
		 */
		$controllers->match('/newUser/step4','LarpManager\Controllers\HomepageController::newUserStep4Action')
					->method('GET')
					->bind('newUser.step4')
					->before($mustBeUser);	
		
		/** Récupére un blason */
		$controllers->match('/blasons/{blason}','LarpManager\Controllers\HomepageController::getBlasonAction')
					->method('GET')
					->bind('blason.get')
					->before($mustBeUser);
					
		/** Affichage de la cartographie du monde de conan */
		$controllers->match('/world','LarpManager\Controllers\HomepageController::worldAction')
					->method('GET')
					->bind('world');
					
		/** Affichage de la cartographie du monde de conan */
		$controllers->match('/world/countriesjson','LarpManager\Controllers\HomepageController::countriesAction')
					->method('GET')
					->bind('world.countries.json');
						
		/** Affichage de la cartographie du monde de conan */
		$controllers->match('/world/regionsjson','LarpManager\Controllers\HomepageController::regionsAction')
					->method('GET')
					->bind('world.regions.json');
					
		/** Affichage de la cartographie du monde de conan */
		$controllers->match('/world/fiefsjson','LarpManager\Controllers\HomepageController::fiefsAction')
					->method('GET')
					->bind('world.fiefs.json');
		
		/** Affichage de la cartographie du monde de conan */
		$controllers->match('/world/groupesjson','LarpManager\Controllers\HomepageController::groupesAction')
					->method('GET')
					->bind('world.groupes.json');
					
		/** Affichage de la cartographie du monde de conan */
		$controllers->match('/world/languesjson','LarpManager\Controllers\HomepageController::languesAction')
					->method('GET')
					->bind('world.langues.json');
											
		/** Mise a jour d'une geographie */
		$controllers->match('/world/countries/{territoire}/update','LarpManager\Controllers\HomepageController::updateCountryGeomAction')
					->method('POST')
					->convert('territoire', 'converter.territoire:convert')
					->bind('world.country.update')
					->before($mustBeScenariste);				
        
        /** Nouvelle cartographie - TESTS */
		$controllers->match('/worldmap','LarpManager\Controllers\HomepageController::worldmapAction')
					->method('GET')
					->bind('worldmap');
		
		/** Nouvelle cartographie - TESTS */
		$controllers->match('/worldmap/json/countries','LarpManager\Controllers\HomepageController::getCountriesAction')
					->method('GET')
					->bind('worldmap.json.countries');
        
        /** Nouvelle cartographie - TESTS */
		$controllers->match('/worldmap/json/countrieslabels','LarpManager\Controllers\HomepageController::getCountriesLabelsAction')
					->method('GET')
					->bind('worldmap.json.countrieslabels');
        
        /** Nouvelle cartographie - TESTS */
		$controllers->match('/worldmap/json/fiefs','LarpManager\Controllers\HomepageController::getFiefsAction')
					->method('GET')
					->bind('worldmap.json.fiefs');
        
        /** Nouvelle cartographie - TESTS */
		$controllers->match('/worldmap/json/fiefslabels','LarpManager\Controllers\HomepageController::getFiefsLabelsAction')
					->method('GET')
					->bind('worldmap.json.fiefslabels');
        
        /** Nouvelle cartographie - TESTS */
		$controllers->match('/worldmap/labelterritoire/{territoire}/update','LarpManager\Controllers\HomepageController::updateLabelTerritoireGeomAction')
					->method('POST')
					->convert('territoire', 'converter.territoire:convert')
					->bind('worldmap.labelterritoire.update');
					
		/** Page de récapitulatif des liens pour discuter */
		$controllers->match('/discuter','LarpManager\Controllers\HomepageController::discuterAction')
					->method('GET')
					->bind('discuter')
					->before($mustBeUser);
		
		/** Page de récapitulatif des liens pour discuter */
		$controllers->match('/evenement','LarpManager\Controllers\HomepageController::evenementAction')
					->method('GET')
					->bind('evenement')
					->before($mustBeUser);					
					
		/** Traitement du formulaire d'inscription d'un joueur dans un groupe */
		$controllers->match('/inscription','LarpManager\Controllers\HomepageController::inscriptionAction')
					->method('POST')
					->bind('homepage.inscription')
					->before($mustBeUser);
		
		/** Formulaire d'inscription d'un joueur dans un gn */
		$controllers->match('/inscriptionGn','LarpManager\Controllers\HomepageController::inscriptionGnFormAction')
					->method('GET')
					->bind('inscriptionGn.form')
					->before($mustBeUser);
		
		/** Traitement du formulaire d'inscription d'un joueur dans un gn */
		$controllers->match('/inscriptionGn','LarpManager\Controllers\HomepageController::inscriptionGnAction')
					->method('POST')
					->bind('inscriptionGn')
					->before($mustBeUser);
				
		/** détail des mentions légales */
		$controllers->match('/legal','LarpManager\Controllers\HomepageController::legalAction')
					->method('GET')
					->bind('legal');
					
		/** Page de présentation du dev de larpManager */
		$controllers->match('/dev','LarpManager\Controllers\HomepageController::devAction')
					->method('GET')
					->bind('dev');
					
		/** Page de présentation du dev de larpManager */
		$controllers->match('/dev/metrics','LarpManager\Controllers\HomepageController::metricsAction')
					->method('GET')
					->bind('dev.metrics');
		
		return $controllers;
	}
}
