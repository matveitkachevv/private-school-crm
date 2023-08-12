<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        if($this->hasAdminData()){
            DB::table('users')->insert([
                'name' => env('USER_LOGIN'),
                'email' => env('USER_EMAIL'),
                'password' =>  (new \Illuminate\Hashing\BcryptHasher)->make(env('USER_PASSWORD'))
            ]);
        }
    }

    private function hasAdminData(): bool
    {
        if(
            !empty(env('USER_LOGIN'))
            && !empty(env('USER_EMAIL'))
            && !empty(env('USER_PASSWORD'))
        )
            return true;
        return false;
    }
}
