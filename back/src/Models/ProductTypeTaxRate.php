<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductTypeTaxRate extends Model
{
    public function productType()
    {
        return $this->belongsTo(ProductType::class);
    }
}