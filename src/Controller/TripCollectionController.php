<?php
namespace App\Controller;

use App\Repository\TripRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TripCollectionController extends AbstractController
{

	public function __invoke(TripRepository $tripRepository)
	{
		// construction de la requête de recherche de trajets
		$query = $tripRepository->createQueryBuilder('t')
		    ->where('t.availablePlaces > 0') // cherche où available_places>0
		    ->getQuery(); // obtention de la requête finale à exécuter

 		// retour de l'exécution de la requête
		return $query->getResult();

	}
}