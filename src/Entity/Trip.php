<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Post;
use App\Controller\TripCreateController;
use App\Repository\TripRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;

#[ORM\Entity(repositoryClass: TripRepository::class)]
#[ApiResource(
    operations: [
        new Post(
            uriTemplate: '/trips/new',
            controller: TripCreateController::class
        ),
    ],
    security: "is_granted('ROLE_USER')",
    normalizationContext: ['groups' => ['trip:read']],
    denormalizationContext: ['groups' => ['trip:write']],
    
)]
class Trip
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['user:read','trip:write','trip:read'])]
    private ?string $startingPoint = null;

    #[ORM\Column(length: 255)]
    #[Groups(['user:read', 'trip:write','trip:read'])]
    private ?string $endingPoint = null;

    #[ORM\Column]
    #[Groups(['trip:write','trip:read'])]
    private ?\DateTimeImmutable $startingAt = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['user:read', 'trip:write', 'trip:read'])]
    private ?int $availablePlaces = null;

    #[ORM\Column]
    #[Groups(['user:read', 'trip:write'])]
    private ?int $price = null;

    #[ORM\ManyToOne(inversedBy: 'trip')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

  

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStartingPoint(): ?string
    {
        return $this->startingPoint;
    }

    public function setStartingPoint(string $startingPoint): static
    {
        $this->startingPoint = $startingPoint;

        return $this;
    }

    public function getEndingPoint(): ?string
    {
        return $this->endingPoint;
    }

    public function setEndingPoint(string $endingPoint): static
    {
        $this->endingPoint = $endingPoint;

        return $this;
    }

    public function getStartingAt(): ?\DateTimeImmutable
    {
        return $this->startingAt;
    }

    public function setStartingAt(\DateTimeImmutable $startingAt): static
    {
        $this->startingAt = $startingAt;

        return $this;
    }

    public function getAvailablePlaces(): ?int
    {
        return $this->availablePlaces;
    }

    public function setAvailablePlaces(?int $availablePlaces): static
    {
        $this->availablePlaces = $availablePlaces;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

}
