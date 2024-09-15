<?php

namespace Pantono\Locations\Event;

use Symfony\Contracts\EventDispatcher\Event;
use Pantono\Locations\Model\Country;

abstract class AbstractCountryEvent extends Event
{
    private Country $current;
    private ?Country $previous = null;

    public function getCurrent(): Country
    {
        return $this->current;
    }

    public function setCurrent(Country $current): void
    {
        $this->current = $current;
    }

    public function getPrevious(): ?Country
    {
        return $this->previous;
    }

    public function setPrevious(?Country $previous): void
    {
        $this->previous = $previous;
    }
}
