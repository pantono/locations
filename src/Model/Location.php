<?php

namespace Pantono\Locations\Model;

use Pantono\Database\Traits\SavableModel;

class Location
{
    use SavableModel;

    private ?int $id = null;
    private string $streetAddress;
    private ?string $poBoxNumber = null;
    private ?string $locality = null;
    private ?string $region = null;
    private string $postalCode;
    private ?string $phone = null;
    private ?string $email = null;
    private ?float $latitude = null;
    private ?float $longitude = null;
    private bool $deleted;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getStreetAddress(): string
    {
        return $this->streetAddress;
    }

    public function setStreetAddress(string $streetAddress): void
    {
        $this->streetAddress = $streetAddress;
    }

    public function getPoBoxNumber(): ?string
    {
        return $this->poBoxNumber;
    }

    public function setPoBoxNumber(?string $poBoxNumber): void
    {
        $this->poBoxNumber = $poBoxNumber;
    }

    public function getLocality(): ?string
    {
        return $this->locality;
    }

    public function setLocality(?string $locality): void
    {
        $this->locality = $locality;
    }

    public function getRegion(): ?string
    {
        return $this->region;
    }

    public function setRegion(?string $region): void
    {
        $this->region = $region;
    }

    public function getPostalCode(): string
    {
        return $this->postalCode;
    }

    public function setPostalCode(string $postalCode): void
    {
        $this->postalCode = $postalCode;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): void
    {
        $this->phone = $phone;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function setLatitude(?float $latitude): void
    {
        $this->latitude = $latitude;
    }

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function setLongitude(?float $longitude): void
    {
        $this->longitude = $longitude;
    }

    public function isDeleted(): bool
    {
        return $this->deleted;
    }

    public function setDeleted(bool $deleted): void
    {
        $this->deleted = $deleted;
    }
}
