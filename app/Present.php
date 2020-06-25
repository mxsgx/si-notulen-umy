<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Present extends Model
{
    /**
     * Atribut yang dapat diisi.
     *
     * @var array
     */
    protected $fillable = [
        'lecturer_id', 'minute_id',
    ];

    /**
     * Mengambil record Lecturer yang berelasi dengan Present.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function lecturer()
    {
        return $this->belongsTo(Lecturer::class, 'lecturer_id', 'id');
    }
}
