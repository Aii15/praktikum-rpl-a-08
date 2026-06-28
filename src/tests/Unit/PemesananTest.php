<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Booking;
use App\Models\Property;

class PemesananTest extends TestCase
{
    /*** Test hitung durasi sewa berhasil (Happy Path & Edge Case).*/
    public function test_hitung_durasi_sewa_berhasil(): void
    {
        // --- 1. ARRANGE ---
        $pemesananSatuHari = new Booking([
            'tanggal_mulai' => '2026-06-01',
            'tanggal_selesai' => '2026-06-01',
        ]);

        $pemesananTigaHari = new Booking([
            'tanggal_mulai' => '2026-06-01',
            'tanggal_selesai' => '2026-06-03',
        ]);

        // --- 2. ACT ---
        $durasiSatuHari = $pemesananSatuHari->duration_in_days;
        $durasiTigaHari = $pemesananTigaHari->duration_in_days;

        // --- 3. ASSERT ---
        $this->assertEquals(1, $durasiSatuHari);
        $this->assertEquals(3, $durasiTigaHari);
    }

    /*** Test hitung total harga sewa berhasil (Happy Path).*/
    public function test_hitung_total_harga_sewa_berhasil(): void
    {
        // --- 1. ARRANGE ---
        $properti = new Property([
            'harga_per_hari' => 150000,
        ]);

        $pemesanan = new Booking([
            'tanggal_mulai' => '2026-06-01',
            'tanggal_selesai' => '2026-06-04', // 4 Hari (1, 2, 3, 4)
        ]);
        
        // Menghubungkan relasi secara manual tanpa database
        $pemesanan->setRelation('property', $properti);

        // --- 2. ACT ---
        $totalHarga = $pemesanan->calculateTotalPrice();

        // --- 3. ASSERT ---
        $this->assertEquals(600000.0, $totalHarga);
    }

    /*** Test hitung total harga sewa ketika properti tidak ada (Unhappy Path).*/
    public function test_hitung_total_harga_sewa_tanpa_properti(): void
    {
        // --- 1. ARRANGE ---
        $pemesanan = new Booking([
            'tanggal_mulai' => '2026-06-01',
            'tanggal_selesai' => '2026-06-04',
        ]);

        // --- 2. ACT ---
        $totalHarga = $pemesanan->calculateTotalPrice();

        // --- 3. ASSERT ---
        $this->assertEquals(0.0, $totalHarga);
    }
}
