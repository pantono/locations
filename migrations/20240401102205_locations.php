<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class Locations extends AbstractMigration
{
    public function up(): void
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

        $names = json_decode(
            file_get_contents(__DIR__ . '/data/countries.json'),
            true
        );
        $iso3 = json_decode(
            file_get_contents(__DIR__ . '/data/iso3.json'),
            true
        );
        $phoneCodes = json_decode(
            file_get_contents(__DIR__ . '/data/phone-codes.json'),
            true
        );

        $currencies = json_decode(
            file_get_contents(__DIR__ . '/data/currencies.json'),
            true
        );

        $countries = [];
        foreach ($names as $iso2 => $name) {
            $countries[] = [
                'name' => $name,
                'iso2' => $iso2,
                'iso3' => $iso3[$iso2],
                'phone_code' => $phoneCodes[$iso2],
                'currency_code' => $currencies[$iso2]
            ];
        }

        $this->table('country')
            ->addColumn('name', 'string')
            ->addColumn('iso2', 'string', ['length' => 2])
            ->addColumn('iso3', 'string', ['length' => 3])
            ->addColumn('phone_code', 'string')
            ->addColumn('currency_code', 'string')
            ->addIndex('iso2')
            ->addIndex('iso3')
            ->insert($countries)
            ->create();

    }

    public function down()
    {
        $this->table('location_history')->drop()->update();
        $this->table('business_location')->drop()->update();
        $this->table('location')->drop()->update();

    }
}
