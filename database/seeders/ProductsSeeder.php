<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use  Illuminate\Support\Facades\DB;
class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert([
            'nombre' => 'Alber',
            'precio' => 10,
            'stock' => 2,
            'descripcion' => 'animal de compañia',
            'image' => base64_encode(file_get_contents('/home/itb/tienda/img/cami.png')),
        ]);

        DB::table('products')->insert([
            'nombre' => 'Rodri',
            'precio' => 16,
            'stock' => 3,
            'descripcion' => 'animal de compañia',
            'image' => base64_encode(file_get_contents('/home/itb/tienda/img/cami.png')),
        ]);

        DB::table('products')->insert([
            'nombre' => 'Kayn',
            'precio' => 24.99,
            'stock' => 5,
            'descripcion' => 'animal de compañia',
            'image' => base64_encode(file_get_contents('/home/itb/tienda/img/cami.png')),
        ]);
    }
}
