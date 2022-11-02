<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    use HasFactory;

    protected $fillable = [
      'id',
      'name',
      'currency_code',
      'exchange_rate',
      'timestamps'
    ];
}
