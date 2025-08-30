<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
  use HasFactory;

  protected $fillable = [
    'contact_id',
    'street',
    'number',
    'complement',
    'neighborhood',
    'city',
    'state',
    'zip',
    'latitude',
    'longitude',
  ];

  public function contact()
  {
    return $this->belongsTo(Contact::class);
  }
}
