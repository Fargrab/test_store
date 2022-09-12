<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class TestUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();
        $user->name = 'Test';
        $user->email = 'test@mail.ru';
        $user->password = md5('testPassword');
        $user->balance = 4000.00;
        $user->save();
    }
}
