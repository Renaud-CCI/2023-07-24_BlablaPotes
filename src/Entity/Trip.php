<?php

namespace App\Entity;

use App\Repository\TripRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TripRepository::class)]
class Trip
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $starting_point = null;

    #[ORM\Column(length: 255)]
    private ?string $ending_point = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $starting_at = null;

    #[ORM\Column(nullable: true)]
    private ?int $available_places = null;

    #[ORM\Column]
    private ?int $price = null;

    #[ORM\ManyToOne(inversedBy: 'trips')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStartingPoint(): ?string
    {
        return $this->starting_point;
    }

    public function setStartingPoint(string $starting_point): static
    {
        $this->starting_point = $starting_point;

        return $this;
    }

    public function getEndingPoint(): ?string
    {
        return $this->ending_point;
    }

    public function setEndingPoint(string $ending_point): static
    {
        $this->ending_point = $ending_point;

        return $this;
    }

    public function getStartingAt(): ?\DateTimeImmutable
    {
        return $this->starting_at;
    }

    public function setStartingAt(\DateTimeImmutable $starting_at): static
    {
        $this->starting_at = $starting_at;

        return $this;
    }

    public function getAvailablePlaces(): ?int
    {
        return $this->available_places;
    }

    public function setAvailablePlaces(?int $available_places): static
    {
        $this->available_places = $available_places;

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
