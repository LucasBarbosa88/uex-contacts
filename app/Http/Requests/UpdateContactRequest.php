<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Rules\ValidCpf;

class UpdateContactRequest extends FormRequest
{
  public function authorize()
  {
    return true;
  }

  public function rules()
  {
    $userId = auth()->user()->id;
    $contactId = $this->route('contact')->id;

    return [
      'name' => 'required|string|max:255',
      'cpf' => [
        'required',
        'string',
        new ValidCpf(),
        Rule::unique('contacts')->where(fn($q) => $q->where('user_id', $userId))->ignore($contactId)
      ],
      'phone' => 'nullable|string|max:30',

      'address.street' => 'required|string|max:255',
      'address.number' => 'nullable|string|max:20',
      'address.complement' => 'nullable|string|max:255',
      'address.neighborhood' => 'nullable|string|max:255',
      'address.city' => 'required|string|max:255',
      'address.state' => 'required|string|size:2',
      'address.zip' => 'required|string|max:9',
    ];
  }
}
