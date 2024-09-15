<?php

namespace Pantono\Locations;

use Pantono\Locations\Repository\LocationsRepository;
use Pantono\Hydrator\Hydrator;
use Pantono\Locations\Model\Location;
use Pantono\Locations\Filter\LocationFilter;
use Pantono\Locations\Model\BusinessLocation;
use Pantono\Locations\Event\PreLocationSaveEvent;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Pantono\Locations\Event\PostLocationSaveEvent;
use Pantono\Locations\Model\Country;
use Pantono\Locations\Filter\CountryFilter;
use Pantono\Locations\Event\PreCountrySaveEvent;
use Pantono\Locations\Event\PostCountrySaveEvent;

class Locations
{
    private LocationsRepository $repository;
    private Hydrator $hydrator;
    private EventDispatcher $dispatcher;

    public function __construct(LocationsRepository $repository, Hydrator $hydrator, EventDispatcher $dispatcher)
    {
        $this->repository = $repository;
        $this->hydrator = $hydrator;
        $this->dispatcher = $dispatcher;
    }

    public function getLocationById(int $id): ?Location
    {
        return $this->hydrator->hydrate(Location::class, $this->repository->getLocationById($id));
    }

    /**
     * @return Location[]
     */
    public function getLocationsByFilter(LocationFilter $filter): array
    {
        return $this->hydrator->hydrateSet(Location::class, $this->repository->getLocationsByFilter($filter));
    }

    public function getBusinessLocationById(int $id): ?BusinessLocation
    {
        return $this->hydrator->hydrate(BusinessLocation::class, $this->repository->getBusinessLocationById($id));
    }

    public function saveLocation(Location $location): void
    {
        $previous = null;
        $event = new PreLocationSaveEvent();
        $event->setCurrent($location);
        if ($location->getId()) {
            $previous = $this->getLocationById($location->getId());
        }
        if ($previous) {
            $event->setPrevious($previous);
        }
        $this->dispatcher->dispatch($event);

        $this->repository->saveLocation($location);

        $event = new PostLocationSaveEvent();
        $event->setCurrent($location);
        if ($previous) {
            $event->setPrevious($previous);
        }
        $this->dispatcher->dispatch($event);
    }

    public function getCountryById(int $id): ?Country
    {
        return $this->hydrator->hydrate(Country::class, $this->repository->getCountryById($id));
    }

    /**
     * @return Country[]
     */
    public function getCountriesByFilter(CountryFilter $filter): array
    {
        return $this->hydrator->hydrateSet(Country::class, $this->repository->getCountriesByFilter($filter));
    }

    public function saveCountry(Country $country): void
    {
        $event = new PreCountrySaveEvent();
        $previous = null;
        if ($country->getId() !== null) {
            $previous = $this->getCountryById($country->getId());
        }
        $event->setCurrent($country);
        if ($previous) {
            $event->setPrevious($previous);
        }
        $this->dispatcher->dispatch($event);

        $this->repository->saveCountry($country);

        $event = new PostCountrySaveEvent();
        $event->setCurrent($country);
        if ($previous) {
            $event->setPrevious($previous);
        }
        $this->dispatcher->dispatch($event);
    }
}
