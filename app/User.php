<?php

namespace App;

use App\Http\Helpers;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    /**
     * Возвращает баланс пользователя для отображения
     *
     * @return string
     */
    public function getBalanceAttribute()
    {
        $balance = DB::table('balances')
            ->where('user_id', $this->id)
            ->orderBy('created_at', 'desc')
            ->first();

        if ($balance) {
            return Helpers::longToMoney($balance->amount);
        }

        return Helpers::longToMoney(0);
    }

    /**
     * Возвращает всех пользователей с их последим созданным перевдом
     *
     * @return Collection
     */
    public static function allWithTransfers()
    {
        $users = DB::table('users as u')
            ->selectRaw('DISTINCT ON (t.user_id)
                                      u.id,
                                      u.name,
                                      u.email,
                                      t.to_user_id,
                                      tu.name to_name,
                                      tu.email to_email,
                                      t.amount,
                                      t.status,
                                      t.created_at,
                                      t.updated_at')
            ->leftJoin('transfers as t', 'u.id', '=', 't.user_id')
            ->leftJoin('users as tu', 'tu.id', '=', 't.to_user_id')
            ->orderBy('t.user_id')
            ->orderBy('t.created_at', 'desc')
            ->get();

        $users->each(function ($el) {
            if (!is_null($el->amount)) {
                $el->amount = Helpers::longToMoney($el->amount);
            }
        });

        return $users;
    }
}
