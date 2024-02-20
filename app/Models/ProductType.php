<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductType extends Model
{
    use HasFactory;

    protected $primaryKey = 'product_type_id';

    protected $fillable = ['name', 'description'];
    public $timestamps = false;
    
    public function products()
    {
        return $this->hasMany(Product::class, 'product_type_id');
    }
}
