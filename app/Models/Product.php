<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $primaryKey = 'product_id';
    protected $fillable = ['product_type_id', 'name', 'description', 'price'];
    protected $casts = ['price' => 'decimal:2'];
    public $timestamps = false;



    public function productType()
    {
        return $this->belongsTo(ProductType::class,  'product_type_id');
    }

    public function variants()
    {
        return $this->hasMany(Variant::class,  'product_type_id');
    }


}
