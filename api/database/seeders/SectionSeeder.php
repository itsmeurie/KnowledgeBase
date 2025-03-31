<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Section;

class SectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sections =
        [
            [
                    'title' => "Overview",
                    'description' => "Provides a general summary of the department's functions, responsibilities, and objectives.",
                    'parent_id' => "1",
                    'office_id' => 1,
            ],
            [
                    'title' => "News",
                    'description' => "sample news description",
                    'parent_id' => "2",
                    'office_id' => 2,
             ],
             [
                    'title' => "Update",
                    'description' => "sample update description",
                    'parent_id' => "2",
                    'office_id' => 1,
            ],
          
        ];
        foreach($sections as $section){
            Section::create($section);
        }
    }
}
