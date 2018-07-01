<?php

namespace App\Rules;

use App\Balance;
use App\Transfer;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class Amount implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string $attribute
     * @param  mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $user_id = Auth::id();
        $balance = Balance::getLast($user_id);
        $transfers = Transfer::sumCurrentUser();
        $available_balance = $balance->amount - $transfers;

        return $value < $available_balance;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'У вас недостаточно средств для создания перевода.';
    }
}
