<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class GudepUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'gudep@kwarran.id'],
            [
                'name'        => 'Admin Gudep',
                'password'    => Hash::make('gudep12345'),
                'role'        => 'humas',
                'permissions' => ['gudep'],
                'is_admin'    => false,
            ]
        );

        $this->command->info('✅ User Admin Gudep berhasil dibuat!');
        $this->command->info('   Email   : gudep@kwarran.id');
        $this->command->info('   Password: gudep12345');
        $this->command->info('   Akses   : Database Gudep & Pangkalan saja');
    }
}
