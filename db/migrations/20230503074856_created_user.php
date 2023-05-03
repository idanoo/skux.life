<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreatedUser extends AbstractMigration
{

    public function change(): void
    {
        $table = $this->table('photos');
        $table->addColumn('created_user', 'integer')
              ->addIndex('created_user', ['name' => 'idx_created_user'])
              ->update();
    }
}
