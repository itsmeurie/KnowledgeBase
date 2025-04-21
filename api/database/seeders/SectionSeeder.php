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
                    'title' => "System",
                    'description' => "Provides a general summary of the department's functions, responsibilities, and objectives.",
                    'contents' => "sample docs",
                    'office_id' => 1,
                    'slug' => "system",
            ],
            [
                    'title' => "News",
                    'description' => "sample news description",
                    'contents' => "sample docs2",
                    'office_id' => 2,
                    'slug' => "news",
             ],
             [
                    'title' => "Update",
                    'description' => "sample update description",
                    'contents' => "sample docs3",
                    'office_id' => 3,
                    'slug' => "update",
            ],
          
        ];
        foreach($sections as $section){
            Section::create($section);
        }
    }
}
