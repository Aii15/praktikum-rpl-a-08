<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Location;
use App\Models\Property;
use App\Models\PropertyCategory;
use App\Models\MitraProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class MitraController extends Controller
{

    protected function ensureMitra()
    {
        $user = Auth::user();

        if (! $user || ! $user->hasRole('mitra')) {
            abort(403, 'Akses hanya untuk Mitra.');
        }

        return $user;
    }

    public function profile()
    {
        $user = $this->ensureMitra();

        return view('mitra.profile', [
            'user' => $user,
            'profile' => $user->mitraProfile,
        ]);
    }

    public function updateProfile(Request $request)
    {
        $user = $this->ensureMitra();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,'.$user->id,
            'no_hp' => ['required','string','regex:/^08[0-9]{8,11}$/','unique:users,no_hp,'.$user->id],
            'ktp' => ['required', 'string', 'regex:/^[0-9]{16}$/'],
            'rekening_bank' => ['nullable', 'string', 'max:50'],
            'nama_mitra' => 'required|string|max:100',
            'password' => 'nullable|string|confirmed|min:8',
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'no_hp.required' => 'Nomor telepon wajib diisi.',
            'no_hp.regex' => 'Nomor telepon harus diawali 08 dan terdiri dari 10 sampai 13 digit angka.',
            'ktp.required' => 'Nomor KTP wajib diisi.',
            'ktp.regex' => 'Nomor KTP harus terdiri dari 16 digit angka.',
            'nama_mitra.required' => 'Nama Mitra/Perusahaan wajib diisi.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.min' => 'Password minimal 8 karakter.',
        ]);

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->no_hp = $request->input('no_hp');
        $user->ktp = $request->input('ktp');
        $user->rekening_bank = $request->input('rekening_bank');

        if ($request->filled('password')) {
            $user->password = Hash::make($request->input('password'));
        }

        $user->save();

        $profile = $user->mitraProfile;
        if (! $profile) {
            $profile = new MitraProfile();
            $profile->user_id = $user->id;
        }

        $profile->nama_mitra = $request->input('nama_mitra');
        $profile->ktp = $request->input('ktp');
        $profile->rekening_bank = $request->input('rekening_bank');
        $profile->save();

        return back()->with('success', 'Profil berhasil diperbarui.');
    }

    public function bookingHistory()
    {
        $user = $this->ensureMitra();

        $bookings = Booking::with(['property', 'user'])
            ->whereHas('property', function ($query) use ($user) {
                $query->where('id_mitra', $user->id);
            })
            ->orderByDesc('tanggal_mulai')
            ->get();

        return view('mitra.bookings', [
            'bookings' => $bookings,
        ]);
    }

    public function properties()
    {
        $user = $this->ensureMitra();

        $properties = Property::with(['coverPhoto', 'category', 'location'])
            ->where('id_mitra', $user->id)
            ->orderByDesc('created_at')
            ->get();

        return view('mitra.properties', [
            'properties' => $properties,
        ]);
    }

    public function createProperty()
    {
        $user = $this->ensureMitra();

        $categories = PropertyCategory::orderBy('nama_kategori')->get();
        $locations = Location::orderBy('kota')->get();

        return view('mitra.property_form', [
            'categories' => $categories,
            'locations' => $locations,
        ]);
    }

    public function storeProperty(Request $request)
    {
        $user = $this->ensureMitra();

        $request->validate([
            'nama_properti' => 'required|string|max:150',
            'id_kategori' => 'required|exists:property_categories,id_kategori',
            'id_lokasi' => 'required|exists:lokasi,id_lokasi',
            'harga_per_hari' => 'required|numeric|min:0',
            'fasilitas' => 'nullable|string|max:1000',
            'deskripsi' => 'required|string',
            'images' => 'nullable|array|max:5',
            'images.*' => 'file|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'nama_properti.required' => 'Nama properti wajib diisi.',
            'id_kategori.required' => 'Kategori properti wajib dipilih.',
            'id_lokasi.required' => 'Lokasi properti wajib dipilih.',
            'harga_per_hari.required' => 'Harga per hari wajib diisi.',
            'deskripsi.required' => 'Deskripsi properti wajib diisi.',
            'images.max' => 'Maksimal 5 foto dapat diunggah.',
            'images.*.image' => 'File harus berupa gambar.',
            'images.*.mimes' => 'Jenis gambar harus jpeg, png, jpg, atau gif.',
            'images.*.max' => 'Ukuran setiap foto maksimal 2MB.',
        ]);

        $property = Property::create([
            'id_mitra' => $user->id,
            'id_kategori' => $request->input('id_kategori'),
            'id_lokasi' => $request->input('id_lokasi'),
            'nama_properti' => $request->input('nama_properti'),
            'deskripsi' => $request->input('deskripsi'),
            'harga_per_hari' => $request->input('harga_per_hari'),
            'fasilitas' => $request->input('fasilitas'),
            'status_pengajuan' => 'pending',
        ]);

        if ($request->hasFile('images')) {
            $files = $request->file('images');
            foreach ($files as $index => $file) {
                $path = $file->store('property_photos', 'public');
                $property->photos()->create([
                    'url_foto' => '/storage/'.$path,
                    'urutan' => $index + 1,
                    'is_cover' => $index === 0,
                ]);
            }
        }

        return redirect()->route('mitra.properties')->with('success', 'Properti berhasil ditambahkan dan diajukan.');
    }

    public function deleteProperty($id)
    {
        $user = $this->ensureMitra();

        $property = Property::where('id_mitra', $user->id)->findOrFail($id);
        $property->delete();

        return back()->with('success', 'Properti berhasil dihapus.');
    }

    public function applicationStatus()
    {
        $user = $this->ensureMitra();

        $properties = Property::with(['category', 'location', 'coverPhoto'])
            ->where('id_mitra', $user->id)
            ->orderByDesc('updated_at')
            ->get();

        return view('mitra.status_pengajuan', [
            'properties' => $properties,
        ]);
    }

    public function bookingDetail($id)
    {
        $user = $this->ensureMitra();

        $booking = Booking::with(['property.coverPhoto', 'property.location', 'user'])
            ->whereHas('property', function ($query) use ($user) {
                $query->where('id_mitra', $user->id);
            })
            ->findOrFail($id);

        return view('mitra.booking_detail', [
            'booking' => $booking,
        ]);
    }

    public function propertyDetail($id)
    {
        $user = $this->ensureMitra();

        $property = Property::with(['category', 'location', 'photos'])
            ->where('id_mitra', $user->id)
            ->findOrFail($id);

        return view('mitra.property_detail', [
            'property' => $property,
        ]);
    }

    public function applicationStatusDetail($id)
    {
        $user = $this->ensureMitra();

        $property = Property::with(['category', 'location', 'photos'])
            ->where('id_mitra', $user->id)
            ->findOrFail($id);

        return view('mitra.status_detail', [
            'property' => $property,
        ]);
    }
}
