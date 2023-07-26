<?php

namespace App\Controller;

use App\Entity\Trip;
use App\Repository\TripRepository;
use App\Repository\UserRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use \Symfony\Bundle\SecurityBundle\Security;

class TripPatchController extends AbstractController
{
    private $security;
    private $serializer;

    public function __construct(Security $security, SerializerInterface $serializer)
    {
        $this->security = $security;
        $this->serializer = $serializer;
    }

    #[Route('/api/trips/modify/{id}', name: 'modify_trip', methods: ['PATCH'])]
    public function __invoke(int $id, Request $request, TripRepository $tripRepository, UserRepository $userRepository, EntityManagerInterface $entityManager): Response
    {
        $requestData = $request->toArray();
        $user = $this->security->getUser();        
        $trip = $tripRepository->findOneBy(['id' => $id]);
        $admin = $userRepository->findOneBy(['id' => 8]);
   

        if ($user === $trip->getUser() || $user == $admin) {
            // $trip->setStartingPoint($requestData['startingPoint']);
            $trip->setEndingPoint($requestData['endingPoint']);
            $startingAt = DateTimeImmutable::createFromFormat('Y-m-d\TH:i:s.u\Z', $requestData['startingAt']);
            $trip->setStartingAt($startingAt);
            $trip->setAvailablePlaces($requestData['availablePlaces']);
            $trip->setPrice($requestData['price']);

            $entityManager->persist($trip);
            $entityManager->flush();

            $response = new Response();
            $response->setContent($this->serializer->serialize($trip, 'json'));
            $response->headers->set('Content-Type', 'application/json');
    
            return $response;
        } else {
            throw new Exception("Error Processing Request", 1);
            
        }
        
    }
}