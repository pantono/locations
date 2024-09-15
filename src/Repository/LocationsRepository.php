<?php

namespace Pantono\Locations\Repository;

use Pantono\Database\Repository\MysqlRepository;
use Pantono\Locations\Model\Location;
use Pantono\Locations\Filter\LocationFilter;
use Pantono\Locations\Model\BusinessLocation;
use Pantono\Locations\Filter\CountryFilter;
use Pantono\Locations\Model\Country;

class LocationsRepository extends MysqlRepository
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
        $select = $this->getDb()->select()->from('location');
        if ($filter->getEmail() !== null) {
            $select->where('email like ?', '%' . $filter->getEmail() . '%');
        }

        if ($filter->getPhone() !== null) {
            $select->where('phone like ?', '%' . $filter->getPhone() . '%');
        }
        if ($filter->getStreetAddress() !== null) {
            $select->where('street_address like ?', '%' . $filter->getStreetAddress() . '%');
        }

        $filter->setTotalResults($this->getCount($select));
        $select->limitPage($filter->getPage(), $filter->getPerPage());

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
        $select = $this->getDb()->select()->from('country');

        if ($filter->getSearch() !== null) {
            $select->where('name like ?', '%' . $filter->getSearch() . '%');
        }
        if ($filter->getIso3()) {
            $select->where('iso3=?', $filter->getIso3());
        }
        if ($filter->getIso2()) {
            $select->where('iso2=?', $filter->getIso2());
        }

        $filter->setTotalResults($this->getCount($select));
        $select->limitPage($filter->getPage(), $filter->getPerPage());
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
