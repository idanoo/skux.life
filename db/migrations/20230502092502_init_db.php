<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class InitDb extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table('photos');
        $table->addColumn('photo_name', 'string')
              ->addColumn('created', 'datetime')
              ->addIndex('photo_name', ['unique' => true])
              ->addIndex('created', [
                'name' => 'idx_created',
                'order' => ['created' => 'DESC']])
              ->create();
    }
}
