<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BarcodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 
        DB::table('barcodes')->insert([
            'name_barcode' => 'S-83',
            'current_barcode' => '100000',
            'status_barcode' => 'Early',
        ]);
    }
}
