<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Office;

class OfficeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $offices = [
            [
                'name' => "City Mayor's Office",
                'code' => "CMO"
            ],
            [
                'name' => "City Administrator's Office",
                'code' => "CADMO"
            ],
        ];


        foreach($offices as $office){
            Office::create($office);
        }
    }
}
