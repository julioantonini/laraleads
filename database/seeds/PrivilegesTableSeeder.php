<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class PrivilegesTableSeeder extends Seeder
{
  public function run()
  {
    DB::table('privileges')->truncate();
    DB::table('privileges')->insert([
      [
        'id' => 1,
        'name' => 'Corretor',
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
      ],
      [
        'id' => 2,
        'name' => 'Gerente',
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
      ],
      [
        'id' => 3,
        'name' => 'Administrador',
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
      ]
      ]
    );
  }
}
