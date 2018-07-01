<?php

namespace App;

use App\Http\Helpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

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
        'user_id', 'to_user_id', 'amount', 'transfer_at',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user()
    {
        return $this->hasOne('App\User', 'id', 'to_user_id');
    }

    /**
     * Возвращает все переводы пользователя с информацией о пользователях для которых перевод
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public static function allCurrentUser()
    {
        $transfers = static::with('user')
            ->where('user_id', '=', Auth::id())
            ->get();

        $transfers->each(function ($el) {
            if (!is_null($el->amount)) {
                $el->amount = Helpers::longToMoney($el->amount);
            }
        });

        return $transfers;
    }

    /**
     * Возвращает сумму переводов пользователя
     *
     * @return mixed
     */
    public static function sumCurrentUser()
    {
        $transfers = static::query()
            ->where('user_id', '=', Auth::id())
            ->get();

        $total = $transfers->reduce(function ($carry, $item) {
            return $carry + $item->amount;
        });

        return $total;
    }
}
