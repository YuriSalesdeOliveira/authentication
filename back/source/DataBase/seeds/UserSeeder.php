<?php
declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

class UserSeeder extends AbstractSeed
{
    public function run()
    {
        $data = [
            [
                'photo' => 'https://media.licdn.com/media/AAYQAQSOAAgAAQAAAAAAAB-zrMZEDXI2T62PSuT6kpB6qg.png',
                'name' => 'Yuri Oliveira',
                'bio' => 'Eu penso que, se a maior parte
                    da minha vida eu irei passar trabalhando,
                    quero trabalhar com algo que eu goste.',
                'phone' => '73999952178',
                'email' => 'yuri_oli@hotmail.com',
                'password' => password_hash('nomedamamae', PASSWORD_DEFAULT),
                
            ]
        ];

        $users = $this->table('users');
        $users->insert($data)->saveData();
    }
}
