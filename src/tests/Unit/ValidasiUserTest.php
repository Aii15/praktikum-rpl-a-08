<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;

class ValidasiUserTest extends TestCase
{
    /*** Test format nomor telepon valid (Happy Path).*/
    public function test_format_nomor_telepon_valid(): void
    {
        // --- 1. ARRANGE ---
        $noHpValid1 = '081234567890'; // 12 digit
        $noHpValid2 = '0812345678';   // 10 digit (panjang minimal)
        $noHpValid3 = '0812345678901'; // 13 digit (panjang maksimal)

        // --- 2. ACT ---
        $hasil1 = User::isValidPhoneNumber($noHpValid1);
        $hasil2 = User::isValidPhoneNumber($noHpValid2);
        $hasil3 = User::isValidPhoneNumber($noHpValid3);

        // --- 3. ASSERT ---
        $this->assertTrue($hasil1);
        $this->assertTrue($hasil2);
        $this->assertTrue($hasil3);
    }

    /*** Test format nomor telepon tidak valid (Unhappy Paths).*/
    public function test_format_nomor_telepon_tidak_valid(): void
    {
        // --- 1. ARRANGE ---
        $noHpTerlaluPendek = '081234567'; // 9 digit
        $noHpTerlaluPanjang = '08123456789012'; // 14 digit
        $noHpBukan08 = '091234567890'; // diawali 09
        $noHpMengandungHuruf = '081234abc890'; // mengandung huruf

        // --- 2. ACT ---
        $hasil1 = User::isValidPhoneNumber($noHpTerlaluPendek);
        $hasil2 = User::isValidPhoneNumber($noHpTerlaluPanjang);
        $hasil3 = User::isValidPhoneNumber($noHpBukan08);
        $hasil4 = User::isValidPhoneNumber($noHpMengandungHuruf);

        // --- 3. ASSERT ---
        $this->assertFalse($hasil1);
        $this->assertFalse($hasil2);
        $this->assertFalse($hasil3);
        $this->assertFalse($hasil4);
    }

    /*** Test format KTP valid (Happy Path).*/
    public function test_format_ktp_valid(): void
    {
        // --- 1. ARRANGE ---
        $ktpValid = '1234567890123456'; // 16 digit

        // --- 2. ACT ---
        $hasil = User::isValidKtp($ktpValid);

        // --- 3. ASSERT ---
        $this->assertTrue($hasil);
    }

    /*** Test format KTP tidak valid (Unhappy Paths).*/
    public function test_format_ktp_tidak_valid(): void
    {
        // --- 1. ARRANGE ---
        $ktpTerlaluPendek = '123456789012345'; // 15 digit
        $ktpTerlaluPanjang = '12345678901234567'; // 17 digit
        $ktpMengandungHuruf = '12345678901234ab'; // mengandung huruf

        // --- 2. ACT ---
        $hasil1 = User::isValidKtp($ktpTerlaluPendek);
        $hasil2 = User::isValidKtp($ktpTerlaluPanjang);
        $hasil3 = User::isValidKtp($ktpMengandungHuruf);

        // --- 3. ASSERT ---
        $this->assertFalse($hasil1);
        $this->assertFalse($hasil2);
        $this->assertFalse($hasil3);
    }
}
