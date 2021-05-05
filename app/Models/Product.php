<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'tb_products';
    protected $primaryKey = 'idproduct';

    protected $fillable = [
        'desproduct',
        'vlprice',
        'vlwidth',
        'vlheight',
        'vllength',
        'vlweight',
        'desurl',
        'dtregister'
    ];

    public $timestamps = false;
}