<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    protected $table = 'tb_productscategories';
    protected $primaryKey = ['idcategory', 'idproduct'];

    public $timestamps = false;

    public function product()
    {
        return $this->belongsTo(Product::class, 'idproduct', 'idproduct');
    }
}