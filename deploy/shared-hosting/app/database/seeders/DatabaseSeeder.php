<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::updateOrCreate(
            ['email' => 'admin@lutongbahay.local'],
            [
                'name' => 'CMS Admin',
                'username' => 'admin',
                'password' => Hash::make('ChangeMe123!'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );

        $this->call(RecipeSeeder::class);
    }
}
