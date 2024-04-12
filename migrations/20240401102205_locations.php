<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class Locations extends AbstractMigration
{
    public function change(): void
    {
        $this->table('location')
            ->addColumn('name', 'string')
            ->addColumn('street_address', 'string')
            ->addColumn('po_box_number', 'string', ['null' => true])
            ->addColumn('locality', 'string', ['null' => true])
            ->addColumn('region', 'string', ['null' => true])
            ->addColumn('postal_code', 'string')
            ->addColumn('phone', 'string', ['null' => true])
            ->addColumn('email', 'string', ['null' => true])
            ->addColumn('latitude', 'point', ['null' => true])
            ->addColumn('longitude', 'point', ['null' => true])
            ->addColumn('deleted', 'boolean')
            ->create();

        $this->table('business_location')
            ->addColumn('location_id', 'integer')
            ->addColumn('name', 'string')
            ->addColumn('reference', 'string')
            ->addIndex('reference', ['unique' => true])
            ->create();

        $this->table('location_history')
            ->addColumn('location_id', 'integer')
            ->addColumn('date', 'datetime')
            ->addColumn('entry', 'string')
            ->create();
    }
}
