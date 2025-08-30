<?php

namespace App\Http\Requests;

use app\Rules\ValidCPF;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreContactRequest extends FormRequest
{
  public function authorize()
  {
    return true;
  }

  public function rules()
  {
    $userId = auth()->id();

    return [
      'name' => 'required|string|max:255',
      'cpf' => [
        'required',
        'string',
        new ValidCPF(),
        Rule::unique('contacts')->where(fn($q) => $q->where('user_id', $userId))
      ],
      'phone' => 'nullable|string|max:30',

      // address fields
      'address.street' => 'required|string|max:255',
      'address.number' => 'nullable|string|max:20',
      'address.complement' => 'nullable|string|max:255',
      'address.neighborhood' => 'nullable|string|max:255',
      'address.city' => 'required|string|max:255',
      'address.state' => 'required|string|size:2',
      'address.zip' => 'required|string|max:9',
    ];
  }

  public function messages()
  {
    return [
      'cpf.unique' => 'Este CPF já está cadastrado para outro contato.',
      'address.street.required' => 'O campo logradouro é obrigatório.',
      'address.city.required' => 'O campo cidade é obrigatório.',
      'address.state.required' => 'O campo UF é obrigatório.',
      'address.zip.required' => 'O campo CEP é obrigatório.',
    ];
  }
}
