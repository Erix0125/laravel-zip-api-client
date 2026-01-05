<?php

namespace App\Http\Controllers;

use App\Services\ZipApiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CityController extends Controller
{
    protected ZipApiService $zipApi;

    public function __construct(ZipApiService $zipApi)
    {
        $this->zipApi = $zipApi;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(int $countyId)
    {
        try {
            $counties = $this->zipApi->getCounties();
            $county = collect($counties)->firstWhere('id', $countyId);

            if (!$county) {
                return redirect()->route('counties.index')->withErrors(['error' => 'County not found']);
            }

            $cities = $this->zipApi->getCities($countyId);
            return view('cities.index', ['county' => $county, 'cities' => $cities, 'countyId' => $countyId]);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(int $countyId)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        try {
            $counties = $this->zipApi->getCounties();
            $county = collect($counties)->firstWhere('id', $countyId);

            if (!$county) {
                return redirect()->route('counties.index')->withErrors(['error' => 'County not found']);
            }

            return view('cities.create', ['county' => $county, 'countyId' => $countyId]);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, int $countyId)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'zip_code' => 'required|string|max:10',
        ]);

        try {
            $this->zipApi->createCity($countyId, $validated['name'], $validated['zip_code']);
            return redirect()->route('cities.index', ['countyId' => $countyId])->with('success', 'City created successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(int $countyId, int $cityId)
    {
        try {
            $counties = $this->zipApi->getCounties();
            $county = collect($counties)->firstWhere('id', $countyId);

            if (!$county) {
                return redirect()->route('counties.index')->withErrors(['error' => 'County not found']);
            }

            $cities = $this->zipApi->getCities($countyId);
            $city = collect($cities)->firstWhere('id', $cityId);

            if (!$city) {
                return redirect()->route('cities.index', ['countyId' => $countyId])->withErrors(['error' => 'City not found']);
            }

            return view('cities.show', ['county' => $county, 'city' => $city, 'countyId' => $countyId]);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $countyId, int $cityId)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        try {
            $counties = $this->zipApi->getCounties();
            $county = collect($counties)->firstWhere('id', $countyId);

            if (!$county) {
                return redirect()->route('counties.index')->withErrors(['error' => 'County not found']);
            }

            $cities = $this->zipApi->getCities($countyId);
            $city = collect($cities)->firstWhere('id', $cityId);

            if (!$city) {
                return redirect()->route('cities.index', ['countyId' => $countyId])->withErrors(['error' => 'City not found']);
            }

            return view('cities.edit', ['county' => $county, 'city' => $city, 'countyId' => $countyId]);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $countyId, int $cityId)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'zip_code' => 'required|string|max:10',
        ]);

        try {
            $this->zipApi->updateCity($countyId, $cityId, $validated['name'], $validated['zip_code']);
            return redirect()->route('cities.index', ['countyId' => $countyId])->with('success', 'City updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $countyId, int $cityId)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        try {
            $this->zipApi->deleteCity($countyId, $cityId);
            return redirect()->route('cities.index', ['countyId' => $countyId])->with('success', 'City deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
