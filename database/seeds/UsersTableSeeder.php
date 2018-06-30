<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $usernames = ['alice', 'bob', 'peter',];

        foreach ($usernames as $username) {
            $user = new User();

            $user->name = $username;
            $user->email = "${username}@example.com";
            $user->password = Hash::make($username);

            $user->save();
        }
    }
}
