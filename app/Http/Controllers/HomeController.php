<?php

namespace App\Http\Controllers;

use App\Http\Helpers;
use App\Rules\Amount;
use App\Transfer;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::allWithTransfers();

        return view('home', ['users' => $users]);
    }

    /**
     * Отображает страницу создания перевода
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function transfer()
    {
        $users = User::all()->except(Auth::id());
        $transfers = Transfer::allCurrentUser();

        return view('transfer', ['users' => $users, 'transfers' => $transfers]);
    }

    public function transferCreate(Request $request)
    {
        $params = $request->all();

        $transfer_at = new Carbon("${params['date']} ${params['time']}");

        $params['user_id'] = Auth::id();
        $params['amount'] = Helpers::moneyToLong($params['amount']);
        $params['status'] = Transfer::STATUS_WAIT;
        $params['transfer_at'] = $transfer_at->toDateTimeString();

        unset($params['date'], $params['time']);

        $validator = Validator::make($params, [
            'user_id' => 'required|exists:users,id',
            'to_user_id' => 'required|exists:users,id',
            'amount' => ['required', 'int', new Amount],
            'transfer_at' => 'required|date|after:now'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator);
        }

        $transfer = new Transfer($params);
        $transfer->save();

        return redirect()->back()->with('status', 'Перевод успешно создан');
    }
}
