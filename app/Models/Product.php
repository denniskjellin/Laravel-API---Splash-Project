<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table ="products";
    
    protected $fillable = [

    'name',
    'supplier_id',
    'category_id',
    'amount',
    'price',
    'image',
    'info'
    ];

    /* supplier or products? */
    public function supplier() {
        return $this->hasOne(Supplier::class);
    }

    public function category() {
        return $this->hasOne(Category::class);
    }

}
