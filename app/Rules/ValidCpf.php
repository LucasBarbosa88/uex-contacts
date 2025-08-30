<?php

namespace app\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidCPF implements ValidationRule
{
  public function validate(string $attribute, mixed $value, Closure $fail): void
  {
    $cpf = preg_replace('/\D/', '', $value);

    if (strlen($cpf) != 11 || preg_match('/(\d)\1{10}/', $cpf)) {
      $fail('O :attribute informado não é um CPF válido.');
      return;
    }

    for ($t = 9; $t < 11; $t++) {
      $d = 0;
      for ($c = 0; $c < $t; $c++) {
        $d += $cpf[$c] * (($t + 1) - $c);
      }
      $d = ((10 * $d) % 11) % 10;
      if ($cpf[$c] != $d) {
        $fail('O :attribute informado não é um CPF válido.');
        return;
      }
    }
  }
}
