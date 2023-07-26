<?php

namespace App\Controller;

use App\Entity\Trip;
use App\Entity\User;
use App\Repository\UserRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Security\Authentication\Token\JWTUserToken;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Request;

class TripCreateController extends AbstractController
{
  private $jwtTokenManager;
  private $userRepository;

  public function __construct(JWTTokenManagerInterface $jwtTokenManager, UserRepository $userRepository)
  {
    $this->jwtTokenManager = $jwtTokenManager;
    $this->userRepository = $userRepository;
  }

  public function __invoke(Request $request, EntityManagerInterface $entityManager)
  {
    $requestData = $request->toArray();

    // Récupérer le token depuis l'en-tête Authorization
    $authorizationHeader = $request->headers->get('Authorization');
    if (!$authorizationHeader) {
      throw new AccessDeniedException('Access denied: Token missing.');
    }

    // Extraire le token depuis l'en-tête Authorization
    $bearerToken = preg_replace('/^Bearer\s/', '', $authorizationHeader);
    $user = new User;
    // Créer un objet JWTUserToken à partir du token
    $token = new JWTUserToken([], $user, $bearerToken);
        
    // Décoder le token pour obtenir l'utilisateur
    $decodedToken = $this->jwtTokenManager->decode($token);

    if (!isset($decodedToken['username'])) {
      throw new AccessDeniedException('Access denied: Invalid token.');
    }

    $user = $this->userRepository->findOneBy(['email' => $decodedToken['username']]);
    if (!$user) {
      throw new AccessDeniedException('Access denied: User not found.');
    }

    // Utilisation de l'utilisateur trouvé
    $trip = new Trip();
    $trip->setUser($user);

    $trip->setPrice($requestData['price']);
    $trip->setStartingPoint($requestData['startingPoint']);
    $trip->setEndingPoint($requestData['endingPoint']);
    $startingAt = DateTimeImmutable::createFromFormat('Y-m-d\TH:i:s.u\Z', $requestData['startingAt']);
    $trip->setStartingAt($startingAt);
    $trip->setAvailablePlaces($requestData['availablePlaces']);


    return $trip;
  }
}