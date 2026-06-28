<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Property;

class PropertiTest extends TestCase
{
    /*** Test format harga ke Rupiah berhasil (Happy Path).*/
    public function test_format_harga_ke_rupiah_berhasil(): void
    {
        // --- 1. ARRANGE ---
        $properti1 = new Property([
            'harga_per_hari' => 150000,
        ]);
        $properti2 = new Property([
            'harga_per_hari' => 2750500,
        ]);

        // --- 2. ACT ---
        $formatRupiah1 = $properti1->formatted_price;
        $formatRupiah2 = $properti2->formatted_price;

        // --- 3. ASSERT ---
        $this->assertEquals('Rp 150.000', $formatRupiah1);
        $this->assertEquals('Rp 2.750.500', $formatRupiah2);
    }

    /*** Test format harga ke Rupiah ketika harga bernilai nol atau null (Edge Case).*/
    public function test_format_harga_nol_atau_null(): void
    {
        // --- 1. ARRANGE ---
        $propertiNol = new Property([
            'harga_per_hari' => 0,
        ]);
        $propertiNull = new Property([
            'harga_per_hari' => null,
        ]);

        // --- 2. ACT ---
        $formatRupiahNol = $propertiNol->formatted_price;
        $formatRupiahNull = $propertiNull->formatted_price;

        // --- 3. ASSERT ---
        $this->assertEquals('Rp 0', $formatRupiahNol);
        $this->assertEquals('Rp 0', $formatRupiahNull);
    }
}
