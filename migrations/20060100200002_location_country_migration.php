<?php

declare(strict_types=1);

use Pantono\Database\Migration\Base\BasePantonoMigration;

final class LocationCountryMigration extends BasePantonoMigration
{
    public function change(): void
    {
        $this->table($this->addTablePrefix('location'))
            ->addLinkedColumn('country_id', $this->addTablePrefix('country'), 'id', ['null' => true])
            ->create();
    }
}
