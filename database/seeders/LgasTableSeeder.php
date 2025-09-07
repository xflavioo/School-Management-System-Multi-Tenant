<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class LgasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('lgas')->delete();

        $states = DB::table('states')->get();

        foreach ($states as $state) {
            $response = Http::get("https://servicodados.ibge.gov.br/api/v1/localidades/estados/{$state->uf}/municipios");
            $cities = $response->json();

            foreach ($cities as $city) {
                DB::table('lgas')->insert([
                    'state_id' => $state->id,
                    'name' => $city['nome'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
