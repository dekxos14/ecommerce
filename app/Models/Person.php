<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    protected $table = 'tb_persons';
    protected $primaryKey = 'idperson';

    const CREATED_AT = 'creation_date';
    const UPDATED_AT = 'updated_date';

    protected $fillable = [
        'desperson',
        'desemail',
        'nrphone',
        'dtregister'
    ];
}
