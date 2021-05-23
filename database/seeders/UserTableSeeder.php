<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
Use App\Models\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name'     => 'Leandro Willian',
            'email'    => 'leandro@email.com',
            'password' => bcrypt('123456')
        ]);
    }
}
