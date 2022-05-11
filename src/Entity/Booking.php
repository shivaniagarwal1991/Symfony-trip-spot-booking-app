<?php

namespace App\Entity;

use App\Repository\BookingRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BookingRepository::class)]
class Booking
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 100)]
    private $user_hash;

    #[ORM\Column(type: 'smallint')]
    private $reserve_spot;

    #[ORM\Column(type: 'smallint')]
    private $status;

    #[ORM\Column(type: 'string', length: 100)]
    private $created_at;

    #[ORM\Column(type: 'string', length: 100)]
    private $updated_at;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserHash(): ?string
    {
        return $this->user_hash;
    }

    public function setUserHash(string $user_hash): self
    {
        $this->user_hash = $user_hash;

        return $this;
    }

    public function getReserveSpot(): ?int
    {
        return $this->reserve_spot;
    }

    public function setReserveSpot(int $reserve_spot): self
    {
        $this->reserve_spot = $reserve_spot;

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getCreatedAt(): ?string
    {
        return $this->created_at;
    }

    public function setCreatedAt(string $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?string
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(string $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }
}
