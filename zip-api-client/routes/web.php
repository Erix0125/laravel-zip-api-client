<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CountyController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\CityFilterController;
use App\Http\Controllers\ExportController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Protected routes - require API token authentication
Route::middleware('api_token')->group(function () {
    // County create/edit/delete
    Route::get('counties/create', [CountyController::class, 'create'])->name('counties.create');
    Route::post('counties', [CountyController::class, 'store'])->name('counties.store');
    Route::get('counties/{countyId}/edit', [CountyController::class, 'edit'])->name('counties.edit');
    Route::patch('counties/{countyId}', [CountyController::class, 'update'])->name('counties.update');
    Route::delete('counties/{countyId}', [CountyController::class, 'destroy'])->name('counties.destroy');

    // City create/edit/delete
    Route::get('counties/{countyId}/cities/create', [CityController::class, 'create'])->name('cities.create');
    Route::post('counties/{countyId}/cities', [CityController::class, 'store'])->name('cities.store');
    Route::get('counties/{countyId}/cities/{cityId}/edit', [CityController::class, 'edit'])->name('cities.edit');
    Route::patch('counties/{countyId}/cities/{cityId}', [CityController::class, 'update'])->name('cities.update');
    Route::delete('counties/{countyId}/cities/{cityId}', [CityController::class, 'destroy'])->name('cities.destroy');

    // Export routes
    Route::get('export/counties/csv', [ExportController::class, 'countiesCSV'])->name('export.counties.csv');
    Route::get('export/counties/pdf', [ExportController::class, 'countiesPDF'])->name('export.counties.pdf');
    Route::get('export/cities/{countyId}/csv', [ExportController::class, 'citiesCSV'])->name('export.cities.csv');
    Route::get('export/cities/{countyId}/pdf', [ExportController::class, 'citiesPDF'])->name('export.cities.pdf');

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Public routes - accessible without authentication
Route::get('counties', [CountyController::class, 'index'])->name('counties.index');
Route::get('counties/{countyId}', [CountyController::class, 'show'])->name('counties.show');
Route::get('counties/{countyId}/cities', [CityController::class, 'index'])->name('cities.index');
Route::get('counties/{countyId}/cities/{cityId}', [CityController::class, 'show'])->name('cities.show');
Route::get('cities/filter', [CityFilterController::class, 'index'])->name('cities.filter');
Route::get('cities/filter/letters/{countyId}', [CityFilterController::class, 'getLetters']);
Route::get('cities/filter/{countyId}/{letter}', [CityFilterController::class, 'getCitiesByLetter'])->name('cities.filter.results');


require __DIR__ . '/auth.php';
