<?php

namespace App\Http\Controllers;

use App\Services\ZipApiService;
use Illuminate\Http\Request;

class CityFilterController extends Controller
{
    protected ZipApiService $zipApi;

    public function __construct(ZipApiService $zipApi)
    {
        $this->zipApi = $zipApi;
    }

    /**
     * Show the ABC filter page
     */
    public function index()
    {
        try {
            $counties = $this->zipApi->getCounties();
            return view('cities.filter', ['counties' => $counties]);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Get available letters for a county (AJAX)
     */
    public function getLetters(int $countyId)
    {
        try {
            $letters = $this->zipApi->getCityLetters($countyId);
            return response()->json(['letters' => $letters]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    /**
     * Get cities by letter for a county
     */
    public function getCitiesByLetter(int $countyId, string $letter)
    {
        try {
            $cities = $this->zipApi->getCitiesByLetter($countyId, strtoupper($letter));
            $counties = $this->zipApi->getCounties();
            $county = collect($counties)->firstWhere('id', $countyId);

            if (!$county) {
                return redirect()->back()->withErrors(['error' => 'County not found']);
            }

            return view('cities.filter-results', [
                'counties' => $counties,
                'county' => $county,
                'countyId' => $countyId,
                'selectedLetter' => strtoupper($letter),
                'cities' => $cities
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
