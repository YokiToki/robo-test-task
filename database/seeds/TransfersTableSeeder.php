<?php

use App\Transfer;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class TransfersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 3; $i++) {
            $date = new Carbon();
            $transfer = new Transfer();

            $transfer->user_id = $i;
            $transfer->to_user_id = $i == 3 ? 1 : $i + 1;
            $transfer->amount = rand(10, 50000);
            $transfer->status = 0;
            $transfer->transfer_at = $date->addMinutes($i)->toDateTimeString();

            $transfer->save();
        }
    }
}
