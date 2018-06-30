<?php

use App\Balance;
use App\User;
use Illuminate\Database\Seeder;

class BalancesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();

        foreach ($users as $user) {
            $balance = new Balance();

            $balance->user_id = $user->id;
            $balance->amount = 50000;

            $balance->save();
        }
    }
}
