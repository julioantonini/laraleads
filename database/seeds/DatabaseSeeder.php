<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
      Eloquent::unguard();


      DB::statement('SET FOREIGN_KEY_CHECKS=0;');

      $this->call(PrivilegesTableSeeder::class);
      $this->call(UsersTableSeeder::class);
      $this->call(FunnelsTableSeeder::class);

      DB::statement('SET FOREIGN_KEY_CHECKS=1;');



    }
}
