<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $table = 'cart'; // Specify the table name if it differs from the model name
    protected $fillable = [
        'user_id',
        'product_id',
    ];
}