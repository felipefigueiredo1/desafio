<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
        /**
     * Prepare a date for array / JSON serialization.
     *
     * @param  \DateTimeInterface  $date
     * @return string
     */
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    protected $hidden = ['updated_at'];

    public function productType()
    {
        return $this->belongsTo(ProductType::class);
    }

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }
}