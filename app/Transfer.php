<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    /**
     * Статус перевода запланированный
     *
     * @var int
     */
    const STATUS_WAIT = 0;

    /**
     * Статус перевода завершенный
     *
     * @var int
     */
    const STATUS_READY = 1;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'amount',
    ];
}
