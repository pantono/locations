<?php

namespace Pantono\Locations\Filter;

use Pantono\Database\Traits\Pageable;
use Pantono\Contracts\Filter\PageableInterface;
use Pantono\Contracts\Types\Geometry\Point;

class LocationFilter implements PageableInterface
{
    use Pageable;

    private ?string $search = null;
    private ?Point $withinPoint = null;
    private ?string $email = null;
    private ?string $streetAddress = null;
    private ?string $phone = null;

    public function getSearch(): ?string
    {
        return $this->search;
    }

    public function setSearch(?string $search): void
    {
        $this->search = $search;
    }

    public function getWithinPoint(): ?Point
    {
        return $this->withinPoint;
    }

    public function setWithinPoint(?Point $withinPoint): void
    {
        $this->withinPoint = $withinPoint;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    public function getStreetAddress(): ?string
    {
        return $this->streetAddress;
    }

    public function setStreetAddress(?string $streetAddress): void
    {
        $this->streetAddress = $streetAddress;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): void
    {
        $this->phone = $phone;
    }
}
