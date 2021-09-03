<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category_product extends Model
{
    use HasFactory;

    protected $table = 'category_product';

    protected $fillable = ['category'];

    public function product(){
        // yang iki hasMany.
        return $this->hasMany(Product::class);
    }
}
