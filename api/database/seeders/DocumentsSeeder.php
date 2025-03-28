<?php

namespace Database\Seeders;

use App\Models\Documents;
use App\Models\Office;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DocumentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $documents = [
            [
                'section_id' => 1,
                'contents' => "About the office 
                VISION

The City Mayor's Office as a model work environment where pride, respect for all individual's commitment to high ethical standards, honesty, teamwork, and achievement of excellence through good governance are its core values.



MISSION

To promote public welfare by committing itself to providing objective, timely, and high quality work in a positive work environment through good and honest governance."
            ],
            ];

        foreach($documents as $document){
            Documents::create($document);
        }
    }
}
