<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'tb_users';
    protected $primaryKey = 'iduser';

    public $timestamps = false;

    protected $fillable = [
        'deslogin',
        'despassword',
        'inadmin'
    ];

    /*public function person()
    {
        return $this->hasOne(Person::class, 'idperson','iduser');
    }*/
}