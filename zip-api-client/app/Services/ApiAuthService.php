<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class ApiAuthService
{
    private string $apiBaseUrl;

    public function __construct()
    {
        $this->apiBaseUrl = config('services.api.base_url');
    }

    /**
     * Login user via API
     *
     * @param string $email
     * @param string $password
     * @return array|null
     */
    public function login(string $email, string $password): ?array
    {
        try {
            $response = Http::post("{$this->apiBaseUrl}/users/login", [
                'email' => $email,
                'password' => $password,
            ]);

            if ($response->successful()) {
                $data = $response->json()['user'];

                // Store token and user info in session
                Session::put('api_token', $data['token']);
                Session::put('user', $data);

                return $data;
            }

            return null;
        } catch (\Exception $e) {
            Log::error('API Login Error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Get current user from session
     *
     * @return array|null
     */
    public function getCurrentUser(): ?array
    {
        return Session::get('user');
    }

    /**
     * Get API token from session
     *
     * @return string|null
     */
    public function getToken(): ?string
    {
        return Session::get('api_token');
    }

    /**
     * Check if user is authenticated
     *
     * @return bool
     */
    public function isAuthenticated(): bool
    {
        return Session::has('api_token') && Session::has('user');
    }

    /**
     * Logout user
     *
     * @return void
     */
    public function logout(): void
    {
        Session::forget('api_token');
        Session::forget('user');
        Session::flush();
    }

    /**
     * Fetch all users from API
     *
     * @return array|null
     */
    public function getAllUsers(): ?array
    {
        try {
            $token = $this->getToken();

            if (!$token) {
                return null;
            }

            $response = Http::withToken($token)
                ->get("{$this->apiBaseUrl}/users");

            if ($response->successful()) {
                return $response->json();
            }

            return null;
        } catch (\Exception $e) {
            Log::error('API Get Users Error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Get user by ID from API
     *
     * @param int $userId
     * @return array|null
     */
    public function getUser(int $userId): ?array
    {
        try {
            $token = $this->getToken();

            if (!$token) {
                return null;
            }

            $response = Http::withToken($token)
                ->get("{$this->apiBaseUrl}/users/{$userId}");

            if ($response->successful()) {
                return $response->json();
            }

            return null;
        } catch (\Exception $e) {
            Log::error('API Get User Error: ' . $e->getMessage());
            return null;
        }
    }
}
