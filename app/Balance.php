<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Balance extends Model
{
    /**
     * Нам нужен только created_at
     *
     * @var null
     */
    const UPDATED_AT = null;

    /**
     * Множитель баланса т.к сумма баланса хранится как int (в копейках)
     *
     * @var int
     */
    const AMOUNT_MULTIPLIER_RUR = 100;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'amount',
    ];

    /**
     * Возвращает баланс пользователя либо null
     *
     * @return mixed
     */
    public static function getLast($user_id)
    {
        $balance = static::query()
            ->where('user_id', $user_id)
            ->orderByRaw('id desc, created_at desc')
            ->first();

        return $balance;
    }
}
