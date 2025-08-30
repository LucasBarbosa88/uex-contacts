<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

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

    if (!empty($data['results'][0]['geometry']['location'])) {
      return $data['results'][0]['geometry']['location'];
    }

    return [];
  }
}
