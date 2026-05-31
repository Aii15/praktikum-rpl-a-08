<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        Role::firstOrCreate(['name' => 'penyewa']);
        Role::firstOrCreate(['name' => 'mitra']);
        Role::firstOrCreate(['name' => 'admin']);
    }
}
