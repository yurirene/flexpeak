<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InventoriesTableSeeder extends Seeder
{
    static $items = [
        "Água",
        "Álcool",
        "Fragrância de Rosas",
        "Fragrância Amadeirada",
        "Fragrância de Algodão"
        ];
    
    public function run()
    {
        foreach (self::$items as $item) {
            DB::table('inventories')->insert([
                'name' => $item,
                'current_qty' => 0,
                'minimal_qty' =>  rand(0,2),
                'is_fragrance' => rand(0,1)
            ]);
        }
    }
}
