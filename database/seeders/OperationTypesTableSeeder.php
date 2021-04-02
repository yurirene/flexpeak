<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OperationTypesTableSeeder extends Seeder
{
    
    
    public function run()
    {
        
        DB::table('operation_types')->insert(
            array(
                [
                    'name' => "Entrada"
                ],
                [
                    "name"=>"Saída"
                ]
            )
        );
    }
}
