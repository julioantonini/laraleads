<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
      DB::table('users')->truncate();
      DB::table('users')->insert([
        [
          'id' => '9197a861-15d5-4226-952d-1803775f4be9',
          'privilege_id' => 3,
          'name' => 'Admin',
          'email' => 'admin@admin.com',
          'password' => Hash::make('12312312'),
          'created_at' => Carbon::now(),
          'updated_at' => Carbon::now(),
        ],
      ]);
    }
}





