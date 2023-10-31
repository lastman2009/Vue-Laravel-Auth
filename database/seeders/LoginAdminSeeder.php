<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class LoginAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::firstOrCreate(
            [
                'email' => 'admin@admin.com',
            ],
            [
                'name' => 'Admin',
                'password' => bcrypt('password'),
            ]
        );
    }
}
