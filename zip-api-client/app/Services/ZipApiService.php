<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Exception;

class ZipApiService
{
    protected string $baseUrl;
    protected ?string $token = null;

    public function __construct()
    {
        $this->baseUrl = config('services.api.base_url') ?? env('API_BASE_URL', 'http://localhost:8000/api');
        // Get token from session (stored during API login)
        $this->token = Session::get('api_token');
    }

    /**
     * Get authorization header
     */
    protected function headers(): array
    {
        $headers = [];
        if ($this->token) {
            $headers['Authorization'] = 'Bearer ' . $this->token;
        }
        return $headers;
    }

    /**
     * List all counties
     */
    public function getCounties()
    {
        $response = Http::withHeaders($this->headers())
            ->get("{$this->baseUrl}/counties");

        if ($response->failed()) {
            throw new Exception("Failed to fetch counties: " . $response->body());
        }

        return $response->json('counties', []);
    }

    /**
     * Create a new county
     */
    public function createCounty(string $name)
    {
        $response = Http::withHeaders($this->headers())
            ->post("{$this->baseUrl}/counties", [
                'name' => $name,
            ]);

        if ($response->failed()) {
            throw new Exception("Failed to create county: " . $response->body());
        }

        return $response->json('county', []);
    }

    /**
     * Update a county
     */
    public function updateCounty(int $countyId, string $name)
    {
        $response = Http::withHeaders($this->headers())
            ->patch("{$this->baseUrl}/counties/{$countyId}", [
                'name' => $name,
            ]);

        if ($response->failed()) {
            throw new Exception("Failed to update county: " . $response->body());
        }

        return $response->json('county', []);
    }

    /**
     * Delete a county
     */
    public function deleteCounty(int $countyId)
    {
        $response = Http::withHeaders($this->headers())
            ->delete("{$this->baseUrl}/counties/{$countyId}");

        if ($response->failed()) {
            throw new Exception("Failed to delete county: " . $response->body());
        }

        return $response->json();
    }

    /**
     * List all cities in a county
     */
    public function getCities(int $countyId)
    {
        $response = Http::withHeaders($this->headers())
            ->get("{$this->baseUrl}/counties/{$countyId}/cities");

        if ($response->failed()) {
            throw new Exception("Failed to fetch cities: " . $response->body());
        }

        return $response->json('cities', []);
    }

    /**
     * Create a new city in a county
     */
    public function createCity(int $countyId, string $name, string $zipCode)
    {
        $response = Http::withHeaders($this->headers())
            ->post("{$this->baseUrl}/counties/{$countyId}/cities", [
                'name' => $name,
                'zip_code' => $zipCode,
            ]);

        if ($response->failed()) {
            throw new Exception("Failed to create city: " . $response->body());
        }

        return $response->json('city', []);
    }

    /**
     * Update a city in a county
     */
    public function updateCity(int $countyId, int $cityId, string $name, string $zipCode)
    {
        $response = Http::withHeaders($this->headers())
            ->patch("{$this->baseUrl}/counties/{$countyId}/cities/{$cityId}", [
                'name' => $name,
                'zip_code' => $zipCode,
            ]);

        if ($response->failed()) {
            throw new Exception("Failed to update city: " . $response->body());
        }

        return $response->json('city', []);
    }

    /**
     * Delete a city in a county
     */
    public function deleteCity(int $countyId, int $cityId)
    {
        $response = Http::withHeaders($this->headers())
            ->delete("{$this->baseUrl}/counties/{$countyId}/cities/{$cityId}");

        if ($response->failed()) {
            throw new Exception("Failed to delete city: " . $response->body());
        }

        return $response->json();
    }

    /**
     * Get first letters of cities in a county
     */
    public function getCityLetters(int $countyId)
    {
        $response = Http::withHeaders($this->headers())
            ->get("{$this->baseUrl}/counties/{$countyId}/abc");

        if ($response->failed()) {
            throw new Exception("Failed to fetch city letters: " . $response->body());
        }

        return $response->json('letters', []);
    }

    /**
     * Get cities in a county starting with a letter
     */
    public function getCitiesByLetter(int $countyId, string $letter)
    {
        $response = Http::withHeaders($this->headers())
            ->get("{$this->baseUrl}/counties/{$countyId}/abc/{$letter}");

        if ($response->failed()) {
            throw new Exception("Failed to fetch cities by letter: " . $response->body());
        }

        return $response->json('cities', []);
    }
}
