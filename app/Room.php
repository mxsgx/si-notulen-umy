<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    /**
     * Atribut yang dapat diisi.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];
}
