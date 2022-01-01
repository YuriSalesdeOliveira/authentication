<?php
declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

class UserSeeder extends AbstractSeed
{
    public function run()
    {
        $data = [
            [
                'name' => 'Yuri Oliveira',
                'email' => 'yuri_oli@hotmail.com',
                'password' => password_hash('nomedamamae', PASSWORD_DEFAULT),
                'is_admin' => 1
            ]
        ];

        $users = $this->table('users');
        $users->insert($data)->saveData();
    }
}
