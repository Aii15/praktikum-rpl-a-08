<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PeranUserTest extends TestCase
{
    use RefreshDatabase;

    /*** Test assign role dan check role status (Happy Path).*/
    public function test_bisa_menambahkan_dan_memeriksa_peran_user(): void
    {
        // --- 1. ARRANGE ---
        $user = User::create([
            'name' => 'Test User',
            'email' => 'user@test.com',
            'password' => bcrypt('password123'),
        ]);

        // --- 2. ACT & ASSERT 1 (Periksa kondisi awal tanpa role) ---
        $this->assertFalse($user->hasRole('mitra'));
        $this->assertFalse($user->isMitra());

        // --- 2. ACT 2 (Assign role 'mitra') ---
        $user->assignRole('mitra');

        // --- 3. ASSERT 2 (Periksa setelah assign role) ---
        $this->assertTrue($user->hasRole('mitra'));
        $this->assertTrue($user->isMitra());
        $this->assertEquals('mitra', $user->primary_role);
    }

    /*** Test assign role baru yang belum ada di database (Edge Case).*/
    public function test_assign_role_baru_akan_membuat_record_role_di_database(): void
    {
        // --- 1. ARRANGE ---
        $user = User::create([
            'name' => 'Admin User',
            'email' => 'admin@test.com',
            'password' => bcrypt('password123'),
        ]);

        // memastikan role 'custom_role' belum ada di database
        $this->assertDatabaseMissing('roles', ['name' => 'custom_role']);

        // --- 2. ACT ---
        $user->assignRole('custom_role');

        // --- 3. ASSERT ---
        $this->assertTrue($user->hasRole('custom_role'));
        $this->assertDatabaseHas('roles', ['name' => 'custom_role']);
    }
}
