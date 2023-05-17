<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function productType()
    {
        return $this->belongsTo(ProductType::class);
    }
}