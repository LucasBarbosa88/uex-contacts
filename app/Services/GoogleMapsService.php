<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log as FacadesLog;

class GoogleMapsService
{
  protected $apiKey;

  public function __construct()
  {
    $this->apiKey = config('services.google_maps.key');
  }

  /**
   * Recebe endereço completo e retorna latitude e longitude
   */
  public function geocodeAddress(string $address): array
  {
    $response = Http::get('https://maps.googleapis.com/maps/api/geocode/json', [
      'address' => $address,
      'key' => $this->apiKey
    ]);

    $data = $response->json();
    // Log para debug
    FacadesLog::info('Google Maps Geocode Response', [
      'address' => $address,
      'status'  => $data['status'] ?? 'NO_STATUS',
      'results' => $data['results'][0]['geometry']['location'] ?? null,
    ]);

    if (($data['status'] ?? null) === 'OK' && !empty($data['results'][0]['geometry']['location'])) {
      return $data['results'][0]['geometry']['location'];
    }

    // Retorna erro amigável
    return [
      'lat' => null,
      'lng' => null,
      'error' => $data['status'] ?? 'UNKNOWN_ERROR'
    ];
  }
}
