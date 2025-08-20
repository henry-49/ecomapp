<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = 'products'; // Specify the table name if it differs from the model name
    protected $fillable = ['title', 'slug', 'price', 'stock', 'description', 'image'];
}