<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Study extends Model
{
    /**
     * Atribut yang dapat diisi.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'faculty_id',
    ];

    /**
     * Mengambil record Faculty yang berelasi dengan Study.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function faculty()
    {
        return $this->belongsTo(Faculty::class, 'faculty_id', 'id');
    }
}
