<?php

namespace App\Http\Controllers;

use App\Models\Location;
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

}


