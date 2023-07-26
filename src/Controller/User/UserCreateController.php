<?php

namespace App\Controller\User;

use ApiPlatform\OpenApi\Model\Response;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserCreateController extends AbstractController
{
  public function __invoke(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $userPasswordHasherInterface)
  {
    // Récupérez les données de la requête POST (le nouvel utilisateur à créer)
    $requestData = $request->toArray();
    // Créez une instance de l'entité User et attribuez les valeurs des champs
    $user = new User();
    $user->setEmail($requestData['email']);
    $user->setPassword($userPasswordHasherInterface->hashPassword($user, $requestData['password']));
    $user->setFirstname($requestData['firstname']);
    $user->setLastname($requestData['lastname']);

    return $user;
  }
}