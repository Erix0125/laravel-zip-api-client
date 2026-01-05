<?php

namespace App\Http\Controllers;

use App\Services\ZipApiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CountyController extends Controller
{
    protected ZipApiService $zipApi;

    public function __construct(ZipApiService $zipApi)
    {
        $this->zipApi = $zipApi;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $counties = $this->zipApi->getCounties();
            return view('counties.index', ['counties' => $counties]);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        return view('counties.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        try {
            $this->zipApi->createCounty($validated['name']);
            return redirect()->route('counties.index')->with('success', 'County created successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $counties = $this->zipApi->getCounties();
            $county = collect($counties)->firstWhere('id', (int)$id);

            if (!$county) {
                return redirect()->route('counties.index')->withErrors(['error' => 'County not found']);
            }

            return view('counties.show', ['county' => $county]);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $counties = $this->zipApi->getCounties();
            $county = collect($counties)->firstWhere('id', (int)$id);

            if (!$county) {
                return redirect()->route('counties.index')->withErrors(['error' => 'County not found']);
            }

            return view('counties.edit', ['county' => $county]);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        try {
            $this->zipApi->updateCounty((int)$id, $validated['name']);
            return redirect()->route('counties.index')->with('success', 'County updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        try {
            $this->zipApi->deleteCounty((int)$id);
            return redirect()->route('counties.index')->with('success', 'County deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
