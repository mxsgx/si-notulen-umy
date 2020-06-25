<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Faculty extends Model
{
    /**
     * Atribut yang dapat diisi.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    /**
     * Mengambil record Study yang berelasi dengan Faculty.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function studies()
    {
        return $this->hasMany(Study::class, 'faculty_id', 'id');
    }
}
