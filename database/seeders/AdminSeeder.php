<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'user_name' => 'admin',
            'password' => \Hash::make('admin'),
            'email' => 'admin@gmail.com',
            'registered_at' => Carbon::now()
        ]);
    }
}
