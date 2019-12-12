<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\User;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
    	User::create([
                    	'user_name' => 'kasir',
                    	'user_password' => Hash::make('kasir'),
                    	'role' =>  'kasir',
                    	'last_login' => Carbon::now(),
                        'remember_token' =>  str_random(10),
                    ],
        );

        User::create([
                    	'user_name' => 'pelayan',
                    	'user_password' => Hash::make('pelayan'),
                    	'role' =>  'pelayan',
                    	'last_login' => Carbon::now(),
                        'remember_token' =>  str_random(10),
                    ],
        );
    }
}
