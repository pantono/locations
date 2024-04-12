<?php

namespace Pantono\Locations\Event;

use Symfony\Contracts\EventDispatcher\Event;
use Pantono\Locations\Model\Location;

abstract class AbstractLocationEvent extends Event
{
    private Location $current;
    private ?Location $previous = null;

    public function getCurrent(): Location
    {
        return $this->current;
    }

    public function setCurrent(Location $current): void
    {
        $this->current = $current;
    }

    public function getPrevious(): ?Location
    {
        return $this->previous;
    }

    public function setPrevious(?Location $previous): void
    {
        $this->previous = $previous;
    }
}
