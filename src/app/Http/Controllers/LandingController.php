<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Location;
use App\Models\Property;
use App\Models\PropertyCategory;

class LandingController extends Controller
{
    public function index(Request $request)
    {
        $selectedLocation = $request->query('location', 'All');
        $selectedCategory = $request->query('category', 'All');
        $selectedPrice = $request->query('price', 'All');

        $locations = Location::orderBy('kota')->get();
        $categories = PropertyCategory::orderBy('nama_kategori')->get();

        $properties = Property::with(['category', 'location', 'coverPhoto', 'reviews'])
            ->when($selectedLocation !== 'All' && $selectedLocation !== '', function ($query) use ($selectedLocation) {
                $query->whereHas('location', function ($locationQuery) use ($selectedLocation) {
                    $locationQuery->where('nama_lokasi', $selectedLocation)
                        ->orWhere('kota', $selectedLocation)
                        ->orWhere('provinsi', $selectedLocation);
                });
            })
            ->when($selectedCategory !== 'All' && $selectedCategory !== '', function ($query) use ($selectedCategory) {
                $query->whereHas('category', function ($categoryQuery) use ($selectedCategory) {
                    $categoryQuery->where('nama_kategori', $selectedCategory);
                });
            })
            ->when($selectedPrice === 'Harga Terendah', function ($query) {
                $query->orderBy('harga_per_hari', 'asc');
            })
            ->when($selectedPrice === 'Harga Tertinggi', function ($query) {
                $query->orderBy('harga_per_hari', 'desc');
            })
            ->get();

        return view('landing', [
            'locations' => $locations,
            'categories' => $categories,
            'properties' => $properties,
            'selectedLocation' => $selectedLocation,
            'selectedCategory' => $selectedCategory,
            'selectedPrice' => $selectedPrice,
        ]);
    }
}
