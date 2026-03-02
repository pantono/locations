<?php

namespace Pantono\Locations\Repository;

use Pantono\Database\Repository\DefaultRepository;
use Pantono\Locations\Model\Location;
use Pantono\Locations\Filter\LocationFilter;
use Pantono\Locations\Model\BusinessLocation;
use Pantono\Locations\Filter\CountryFilter;
use Pantono\Locations\Model\Country;

class LocationsRepository extends DefaultRepository
{
    public function getLocationById(int $id): ?array
    {
        return $this->selectSingleRow('location', 'id', $id);
    }

    public function saveLocation(Location $location): void
    {
        $id = $this->insertOrUpdate('location', 'id', $location->getId(), $location->getAllData());
        if ($id) {
            $location->setId($id);
        }
    }

    public function getLocationsByFilter(LocationFilter $filter): array
    {
        $select = $this->getDb()->select('l.*')->from('location', 'l');
        if ($filter->getEmail() !== null) {
            $select->where('l.email like :email')
                ->setParameter(':email', '%' . $filter->getEmail() . '%');
        }

        if ($filter->getPhone() !== null) {
            $select->where('l.phone like :phone')
                ->setParameter('phone', '%' . $filter->getPhone() . '%');
        }
        if ($filter->getStreetAddress() !== null) {
            $select->where('l.street_address like :street_address')
                ->setParameter('street_address', '%' . $filter->getStreetAddress() . '%');
        }

        $this->applyCountAndLimit($select, $filter);

        return $this->getDb()->fetchAll($select);
    }

    public function saveBusinessLocation(BusinessLocation $location): void
    {
        $id = $this->insertOrUpdate('business_location', 'id', $location->getId(), $location->getAllData());
        if ($id) {
            $location->setId($id);
        }
    }

    public function getBusinessLocationById(int $id): ?array
    {
        return $this->selectSingleRow('business_location', 'id', $id);
    }

    public function getCountryById(int $id): ?array
    {
        return $this->selectSingleRow('country', 'id', $id);
    }

    public function getCountriesByFilter(CountryFilter $filter): array
    {
        $select = $this->getDb()->select('c.*')->from('country', 'c')
            ->addOrderBy($filter->getOrder());

        if ($filter->getSearch() !== null) {
            $select->where('c.name like :search')
                ->setParameter('search', '%' . $filter->getSearch() . '%');
        }
        if ($filter->getIso3()) {
            $select->where('iso3=:iso3')
                ->setParameter('iso3', $filter->getIso3());
        }
        if ($filter->getIso2()) {
            $select->where('iso2=?')
                ->setParameter('iso2', $filter->getIso2());
        }

        $this->applyCountAndLimit($select, $filter);
        return $this->getDb()->fetchAll($select);
    }

    public function saveCountry(Country $country): void
    {
        $id = $this->insertOrUpdateCheck('country', 'id', $country->getId(), $country->getAllData());
        if ($id) {
            $country->setId($id);
        }
    }
}
