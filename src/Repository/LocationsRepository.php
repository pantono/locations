<?php

namespace Pantono\Locations\Repository;

use Pantono\Database\Repository\MysqlRepository;
use Pantono\Locations\Model\Location;
use Pantono\Locations\Filter\LocationFilter;
use Pantono\Locations\Model\BusinessLocation;

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
}
