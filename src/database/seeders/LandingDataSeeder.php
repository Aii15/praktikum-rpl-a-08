<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Location;
use App\Models\Property;
use App\Models\PropertyCategory;
use App\Models\PropertyPhoto;
use App\Models\Review;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class LandingDataSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $mitra = User::firstOrCreate(
            ['email' => 'mitra@example.com'],
            [
                'name' => 'Mitra Sample',
                'no_hp' => '081234567890',
                'password' => Hash::make('password'),
                'role' => 'mitra',
            ]
        );

        $penyewa = User::firstOrCreate(
            ['email' => 'user@example.com'],
            [
                'name' => 'Penyewa Sample',
                'no_hp' => '081298765432',
                'password' => Hash::make('password'),
                'role' => 'penyewa',
            ]
        );

        $mitraRole = Role::firstOrCreate(['name' => 'mitra']);
        $penyewaRole = Role::firstOrCreate(['name' => 'penyewa']);

        if (! $mitra->roles()->where('role_id', $mitraRole->id)->exists()) {
            $mitra->roles()->attach($mitraRole->id);
        }

        if (! $penyewa->roles()->where('role_id', $penyewaRole->id)->exists()) {
            $penyewa->roles()->attach($penyewaRole->id);
        }

        $categories = collect([
            'Komersial',
            'Hunian',
            'Studio',
            'Heritage',
            'Lanskap',
            'Fasilitas Publik',
            'Industrial',
        ])->map(fn ($name) => PropertyCategory::firstOrCreate(['nama_kategori' => $name]));

        $locations = collect([
            ['nama_lokasi' => 'Jakarta Barat', 'alamat_detail' => 'Jl. Pintu Air No. 7, Jakarta Barat', 'kota' => 'Jakarta', 'provinsi' => 'DKI Jakarta', 'kode_pos' => '11230'],
            ['nama_lokasi' => 'Ubud, Bali', 'alamat_detail' => 'Jl. Raya Ubud No. 21, Ubud', 'kota' => 'Gianyar', 'provinsi' => 'Bali', 'kode_pos' => '80571'],
            ['nama_lokasi' => 'Bandung', 'alamat_detail' => 'Jl. Dago No. 12, Bandung', 'kota' => 'Bandung', 'provinsi' => 'Jawa Barat', 'kode_pos' => '40135'],
            ['nama_lokasi' => 'Yogyakarta', 'alamat_detail' => 'Jl. Malioboro No. 10, Yogyakarta', 'kota' => 'Yogyakarta', 'provinsi' => 'DI Yogyakarta', 'kode_pos' => '55271'],
            ['nama_lokasi' => 'Semarang Tengah', 'alamat_detail' => 'Jl. Pemuda, Sekayu, Kec. Semarang Tengah', 'kota' => 'Semarang', 'provinsi' => 'Jawa Tengah', 'kode_pos' => '50132'],
        ])->map(fn ($data) => Location::firstOrCreate($data));

        $properties = collect([
            [
                'nama_properti' => 'Kota Tua Jakarta',
                'deskripsi' => 'Properti ikonik bergaya heritage di tengah pusat kota Jakarta dengan akses mudah dan ruang serbaguna untuk syuting.',
                'harga_per_periode' => 15000000.00,
                'fasilitas' => 'Sanitasi, Listrik dan Penerangan, Parkir Mobil, Outdoor',
                'id_kategori' => $categories->firstWhere('nama_kategori', 'Komersial')->id_kategori,
                'id_lokasi' => $locations->firstWhere('kota', 'Jakarta')->id_lokasi,
            ],
            [
                'nama_properti' => 'Villa Ubud',
                'deskripsi' => 'Villa mewah di Bali dengan area outdoor hijau dan pemandangan alam, cocok untuk video lifestyle dan promo.',
                'harga_per_periode' => 10000000.00,
                'fasilitas' => 'Sanitasi, Listrik dan Penerangan, Parkir Mobil, CCTV, Outdoor',
                'id_kategori' => $categories->firstWhere('nama_kategori', 'Hunian')->id_kategori,
                'id_lokasi' => $locations->firstWhere('kota', 'Gianyar')->id_lokasi,
            ],
            [
                'nama_properti' => 'Studio',
                'deskripsi' => 'Studio modern lengkap dengan lighting, properti, dan ruang ganti untuk sesi foto dan shooting komersial.',
                'harga_per_periode' => 8000000.00,
                'fasilitas' => 'Sanitasi, Listrik dan Penerangan, CCTV, APAR, Parkir Mobil',
                'id_kategori' => $categories->firstWhere('nama_kategori', 'Studio')->id_kategori,
                'id_lokasi' => $locations->firstWhere('kota', 'Bandung')->id_lokasi,
            ],
            [
                'nama_properti' => 'Lawang Sewu',
                'deskripsi' => 'Bangunan bersejarah terkenal di Kota Semarang, Jawa Tengah. Terkenal dengan arsitektur pintu yang megah dan sangat ikonik untuk produksi video, film, atau sesi foto pre-wedding bernuansa klasik.',
                'harga_per_periode' => 150000000.00,
                'fasilitas' => 'Sanitasi, Listrik dan Penerangan, CCTV, Parkir Mobil, Sprinkler Water, Permit Included, APAR, Outdoor',
                'id_kategori' => $categories->firstWhere('nama_kategori', 'Heritage')->id_kategori,
                'id_lokasi' => $locations->firstWhere('kota', 'Semarang')->id_lokasi,
            ],
        ])->map(function ($data) use ($mitra) {
            return Property::updateOrCreate([
                'nama_properti' => $data['nama_properti'],
            ], array_merge($data, [
                'id_mitra' => $mitra->id,
            ]));
        });

        $photos = [
            [
                'property_name' => 'Kota Tua Jakarta',
                'url_foto' => '/images/informasi/tua2.png',
                'urutan' => 1,
                'is_cover' => true,
            ],
            [
                'property_name' => 'Kota Tua Jakarta',
                'url_foto' => '/images/landing/property.png',
                'urutan' => 2,
                'is_cover' => false,
            ],
            [
                'property_name' => 'Villa Ubud',
                'url_foto' => '/images/landing/villa_ubud.png',
                'urutan' => 1,
                'is_cover' => true,
            ],
            [
                'property_name' => 'Villa Ubud',
                'url_foto' => '/images/informasi/ubud2.png',
                'urutan' => 2,
                'is_cover' => false,
            ],
            [
                'property_name' => 'Villa Ubud',
                'url_foto' => '/images/informasi/ubud3.png',
                'urutan' => 3,
                'is_cover' => false,
            ],
            [
                'property_name' => 'Studio',
                'url_foto' => '/images/landing/studio.png',
                'urutan' => 1,
                'is_cover' => true,
            ],
            [
                'property_name' => 'Studio',
                'url_foto' => '/images/informasi/studio2.png',
                'urutan' => 2,
                'is_cover' => false,
            ],
            [
                'property_name' => 'Studio',
                'url_foto' => '/images/informasi/studio3.png',
                'urutan' => 3,
                'is_cover' => false,
            ],
            [
                'property_name' => 'Studio',
                'url_foto' => '/images/informasi/studio4.png',
                'urutan' => 4,
                'is_cover' => false,
            ],
            [
                'property_name' => 'Lawang Sewu',
                'url_foto' => '/images/informasi/prop1.png',
                'urutan' => 1,
                'is_cover' => true,
            ],
            [
                'property_name' => 'Lawang Sewu',
                'url_foto' => '/images/informasi/prop2.png',
                'urutan' => 2,
                'is_cover' => false,
            ],
            [
                'property_name' => 'Lawang Sewu',
                'url_foto' => '/images/informasi/prop3.png',
                'urutan' => 3,
                'is_cover' => false,
            ],
            [
                'property_name' => 'Lawang Sewu',
                'url_foto' => '/images/informasi/prop4.png',
                'urutan' => 4,
                'is_cover' => false,
            ],
            [
                'property_name' => 'Lawang Sewu',
                'url_foto' => '/images/informasi/prop5.png',
                'urutan' => 5,
                'is_cover' => false,
            ],
        ];

        foreach ($photos as $photo) {
            $property = $properties->firstWhere('nama_properti', $photo['property_name']);
            if ($property) {
                PropertyPhoto::updateOrCreate([
                    'id_properti' => $property->id_properti,
                    'urutan' => $photo['urutan'],
                ], [
                    'id_properti' => $property->id_properti,
                    'url_foto' => $photo['url_foto'],
                    'urutan' => $photo['urutan'],
                    'is_cover' => $photo['is_cover'],
                ]);
            }
        }

        $booking = Booking::updateOrCreate([
            'id_properti' => $properties->firstWhere('nama_properti', 'Kota Tua Jakarta')->id_properti,
            'id_user' => $penyewa->id,
            'tanggal_mulai' => '2026-07-01',
            'tanggal_selesai' => '2026-07-07',
        ], [
            'status_booking' => 'confirmed',
        ]);

        Review::updateOrCreate([
            'id_booking' => $booking->id_booking,
        ], [
            'rating' => 5,
            'komentar' => 'Tempat syutingnya sangat strategis dan fasilitasnya lengkap. Sangat puas!',
            'tanggal_review' => now(),
        ]);

        $bookingLS = Booking::updateOrCreate([
            'id_properti' => $properties->firstWhere('nama_properti', 'Lawang Sewu')->id_properti,
            'id_user' => $penyewa->id,
            'tanggal_mulai' => '2026-06-10',
            'tanggal_selesai' => '2026-06-12',
        ], [
            'status_booking' => 'confirmed',
        ]);

        Review::updateOrCreate([
            'id_booking' => $bookingLS->id_booking,
        ], [
            'rating' => 5,
            'komentar' => 'Sangat bersejarah dan eksotis, pencahayaan alami di sore hari sangat bagus untuk syuting film indie kami.',
            'tanggal_review' => now()->subDays(5),
        ]);

        $bookingLS2 = Booking::updateOrCreate([
            'id_properti' => $properties->firstWhere('nama_properti', 'Lawang Sewu')->id_properti,
            'id_user' => $mitra->id,
            'tanggal_mulai' => '2026-06-20',
            'tanggal_selesai' => '2026-06-25',
        ], [
            'status_booking' => 'confirmed',
        ]);

        Review::updateOrCreate([
            'id_booking' => $bookingLS2->id_booking,
        ], [
            'rating' => 4,
            'komentar' => 'Sangat luas dan arsitekturnya indah sekali. Pengurusan perizinannya juga cukup cepat.',
            'tanggal_review' => now()->subDays(2),
        ]);
    }
}
