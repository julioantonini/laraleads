<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class FunnelsTableSeeder extends Seeder
{
  public function run()
  {
    DB::table('funnels')->truncate();
    DB::table('funnels')->insert([
      [
        'id' => 1,
        'name' => 'Geral',
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
      ],
      [
        'id' => 2,
        'name' => 'Contatados',
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
      ],
      [
        'id' => 3,
        'name' => 'Plantão',
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
      ],
      [
        'id' => 4,
        'name' => 'Análise',
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
      ],
      [
        'id' => 5,
        'name' => 'Venda',
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
      ],
      [
        'id' => 6,
        'name' => 'Sem perfil',
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
      ],
    ]);
  }
}
