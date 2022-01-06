<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateUsersTable extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table('users');
        $table->addColumn('photo', 'string')
        ->addColumn('name', 'string', ['limit' => 200])
        ->addColumn('bio', 'string', ['limit' => 500])
        ->addColumn('phone', 'string', ['limit' => 11])
        ->addColumn('email', 'string', ['limit' => 200])
        ->addColumn('password', 'string', ['limit' => 200])
        ->addColumn('created_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
        ->addColumn('updated_at', 'timestamp', ['null' => true])
        ->addIndex('email', ['unique' => true])
        ->create();
    }
}
