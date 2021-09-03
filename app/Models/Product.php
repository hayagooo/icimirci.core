<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = ['name', 'image', 'description', 'category_id'];

    public function category_product(){
        // kebalik. iki seharuse belongsto
        return $this->belongsTo(Category_product::class);
    }
}
