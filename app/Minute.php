<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Minute extends Model
{
    /**
     * Atribut yang dapat diisi.
     *
     * @var array
     */
    protected $fillable = [
        'agenda', 'lecturer_id', 'meeting_id', 'room_id',
        'meeting_date', 'start_at', 'end_at', 'note',
        'study_id', 'notulis_id'
    ];

    /**
     * Atribut yang akan dipanggil secara native.
     *
     * @var string[]
     */
    protected $casts = [
        'meeting_date' => 'date',
    ];

    /**
     * Konversi atribute start_at ke Carbon.
     *
     * @param $start_at
     * @return Carbon
     */
    public function getStartAtAttribute($start_at)
    {
        return Carbon::createFromFormat('H:i:s', $start_at);
    }

    /**
     * Konversi atribute end_at ke Carbon.
     *
     * @param $end_at
     * @return Carbon
     */
    public function getEndAtAttribute($end_at)
    {
        return Carbon::createFromFormat('H:i:s', $end_at);
    }

    /**
     * Mengambil record Lecturer yang berelasi dengan Minute.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function lecturer()
    {
        return $this->belongsTo(Lecturer::class, 'lecturer_id', 'id');
    }

    /**
     * Mengambil record Lecturer sebagai Notulis yang berelasi dengan Minute.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function notulis()
    {
        return $this->belongsTo(Lecturer::class, 'notulis_id', 'id');
    }

    /**
     * Mengambil record Meeting yang berelasi dengan Minute.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function meeting()
    {
        return $this->belongsTo(Meeting::class, 'meeting_id', 'id');
    }

    /**
     * Mengambil record Room yang berelasi dengan Minute.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id', 'id');
    }

    /**
     * Mengambil record Present yang berelasi dengan Minute.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function presents()
    {
        return $this->hasMany(Present::class, 'minute_id', 'id');
    }

    /**
     * Mengambil record Document yang berelasi dengan Minute.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function documents()
    {
        return $this->hasMany(Document::class, 'minute_id', 'id');
    }
}
