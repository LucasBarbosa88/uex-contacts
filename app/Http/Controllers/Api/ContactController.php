<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreContactRequest;
use App\Http\Requests\UpdateContactRequest;
use App\Models\Contact;
use App\Models\Address;
use App\Services\GoogleMapsService;
use Illuminate\Http\Request;

class ContactController extends Controller
{
  public function index(Request $request)
  {
    $user = $request->user();
    $search = $request->get('search');

    $contacts = $user->contacts()
      ->with('address')
      ->when($search, fn($q) => $q->where('name', 'like', "%{$search}%")
        ->orWhere('cpf', 'like', "%{$search}%"))
      ->orderBy('name', 'asc')
      ->paginate($request->get('per_page', 10));

    return response()->json($contacts);
  }

  public function store(StoreContactRequest $request, GoogleMapsService $gmaps)
  {
    $data = $request->validated();

    $contact = Contact::create([
      'user_id' => $request->user()->id,
      'name' => $data['name'],
      'cpf' => preg_replace('/\D/', '', $data['cpf']),
      'phone' => $data['phone'] ?? null,
    ]);

    $address = $data['address'];
    $fullAddress = "{$address['street']}, {$address['number']}, {$address['city']} - {$address['state']}, {$address['zip']}";
    $geo = $gmaps->geocodeAddress($fullAddress);

    $contact->address()->create([
      ...$address,
      'latitude' => $geo['lat'] ?? null,
      'longitude' => $geo['lng'] ?? null,
    ]);

    return response()->json($contact->load('address'), 201);
  }

  public function destroy(Contact $contact)
  {
    $contact->delete();
    return response()->json(['message' => 'Contato deletado com sucesso']);
  }
}
