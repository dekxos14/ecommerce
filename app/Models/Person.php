<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    protected $table = 'tb_persons';
    protected $primaryKey = 'idperson';

    protected $fillable = [
        'desperson',
        'desemail',
        'nrphone'
    ];

    public $timestamps = false;

    public function user()
    {
        return $this->hasOne(User::class, 'idperson', 'idperson');
    }
}
