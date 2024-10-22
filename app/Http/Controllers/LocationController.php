<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\Polygon;
use App\Models\Polyline;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function index()
    {
        $locations = Location::all();

        return view('locations.index', compact('locations'));
    }


    public function create()
    {
        return view('locations.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'description' => 'required',
        ]);

        Location::create($request->all());
        return redirect()->route('map.index')->with('success', 'Location created successfully.');
    }

    public function edit(Location $location)
    {
        return view('locations.edit', compact('location'));
    }

    public function update(Request $request, Location $location)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'description' => 'required',
        ]);

        $location->update($request->all());

        return redirect()->route('map.index')->with('success', 'Location updated successfully.');
    }

    public function destroy($id)
    {
        $location = Location::findOrFail($id);
        $location->delete();

        return redirect()->route('map.index')->with('success', 'Location deleted successfully');
    }



    public function map()
    {
        $locations = Location::all(); // Ambil semua data lokasi

        return view('map', compact('locations')); // Kirim data ke view map
    }

    public function show(Location $location)
    {
        return view('locations.show', compact('location'));
    }

    public function storePolygon(Request $request)
    {
        // Validate input
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'polygon' => 'required|json'
        ]);

        // Create a new location
        $location = new Location();
        $location->name = $request->name;
        $location->description = $request->description;
        $location->latitude = 0;
        $location->longitude = 0;
        $location->polygon = $request->polygon; // Store polygon as GeoJSON
        $location->save();

        return response()->json(['success' => true]);
    }

    // Fungsi tambahan untuk export data location menjadi file JSON
    public function exportLocationJson($id)
    {
        // Ambil data dari tabel locations berdasarkan id
        $location = Location::findOrFail($id);

        // Konversi data ke array untuk mempermudah pengelolaan
        $locationArray = $location->toArray();

        // Nama file JSON yang akan disimpan
        $fileName = 'location_' . $id . '.json';
        $filePath = public_path('json/' . $fileName);

        // Simpan data ke file JSON dengan format yang rapi
        file_put_contents($filePath, json_encode($locationArray, JSON_PRETTY_PRINT));

        // Kembalikan file sebagai response untuk diunduh
        return response()->download($filePath);
    }

    public function exportAllLocationsJson()
    {
        $locations = Location::all();
        $locationsArray = $locations->toArray();
        $fileName = 'all_locations.json';
        $filePath = public_path('json/' . $fileName);

        file_put_contents($filePath, json_encode($locationsArray, JSON_PRETTY_PRINT));

        return response()->download($filePath)->deleteFileAfterSend(true);
    }

    // LocationController.php
    public function getSavedPolygons() {
        $locations = Location::whereNotNull('polygon')->get();
        return response()->json($locations);
    }

    

}
