<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'tb_users';
    protected $primaryKey = 'iduser';

    const CREATED_AT = 'creation_date';
    const UPDATED_AT = 'updated_date';

    protected $fillable = [
        'idperson',
        'deslogin',
        'despassword',
        'inadmin',
        'dtregister'
    ];
}