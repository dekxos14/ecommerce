<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    protected $table = 'tb_persons';
    protected $primaryKey = 'idperson';

    public $timestamps = false;

    protected $fillable = [
        'desperson',
        'desemail',
        'nrphone',
    ];

    /*public function user()
    {
        return $this->belongsTo(User::class, 'idperson','iduser');
    }*/
}
