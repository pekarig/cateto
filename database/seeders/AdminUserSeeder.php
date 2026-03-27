<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Gabriel',
            'email' => 'admin@cateto.net',
            'password' => Hash::make('123456789'),
        ]);
        
        $this->command->info('Admin felhasználó létrehozva: admin@cateto.net');
    }
}
