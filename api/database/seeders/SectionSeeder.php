<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Section;

class SectionSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        $sections = [
            [
                "title" => "System",
                "description" => "Provides a general summary of the department's functions, responsibilities, and objectives.",
                "contents" => "sample docs",
                "office_id" => 1,
                "slug" => "system",
            ],
            [
                "title" => "News",
                "description" => "sample news description",
                "contents" => "sample docs2",
                "office_id" => 2,
                "slug" => "news",
            ],
            [
                "title" => "Inventory System",
                "description" => "a process that tracks and manages a company's stock, supplies, and sales throughout its supply chain",
                "contents" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean cursus leo nisi, a viverra leo pharetra vitae. Mauris posuere luctus volutpat. In varius, odio a rhoncus pellentesque, orci ex gravida neque, quis dictum sem sem a lacus. Donec bibendum accumsan eros sed pellentesque. Donec vehicula a elit ac posuere. Duis luctus auctor vehicula. Mauris rhoncus quam non risus vestibulum volutpat. In hac habitasse platea dictumst. Vestibulum et mollis libero.

Curabitur porta sagittis pharetra. Donec lobortis ligula nisl, vel mollis risus posuere id. Etiam vestibulum auctor sapien, sit amet placerat diam maximus ut. Nunc ultrices, magna in suscipit hendrerit, nibh orci euismod odio, non sagittis erat erat id purus. Praesent in est orci. Sed eu ligula a enim dignissim finibus et in nisl. Suspendisse ullamcorper nibh a elementum suscipit. Phasellus id leo ac nisi mattis volutpat. Praesent a tincidunt sapien, a euismod justo.

Quisque porttitor urna tellus, vel accumsan quam lacinia quis. Suspendisse potenti. Ut lorem massa, porttitor a magna a, dictum pellentesque ipsum. Cras massa metus, convallis sit amet rutrum vitae, euismod non ligula. Maecenas placerat, purus interdum condimentum venenatis, magna enim aliquam libero, non luctus orci odio ac orci. Sed eleifend felis at sapien tincidunt, sed mollis turpis condimentum. Pellentesque at enim a nisl interdum ultrices. Aenean sit amet ante vel urna bibendum tincidunt a eget ex. Nulla dui ipsum, ultricies a turpis et, pretium elementum libero. Nunc facilisis a justo nec commodo. Morbi fermentum vitae dui a interdum. Donec euismod id mauris cursus faucibus. Ut convallis a massa sit amet varius. In vehicula purus egestas, ornare urna id, pretium lectus. In hac habitasse platea dictumst.

Sed imperdiet turpis elit, et auctor turpis feugiat sit amet. Duis libero quam, tincidunt eget risus eu, elementum faucibus nisl. Fusce at sagittis risus. Duis interdum turpis et urna dignissim, vitae accumsan ex venenatis. Mauris tincidunt eros enim, et viverra sem interdum eget. Quisque gravida libero quis massa mattis eleifend. Ut imperdiet blandit tellus eget sagittis.

Fusce mauris ex, sollicitudin sed justo in, viverra dignissim turpis. Aliquam erat volutpat. Praesent vestibulum vestibulum imperdiet. Nunc non ultricies lectus. Proin eget quam ac lacus luctus maximus. Nunc sem risus, facilisis ac magna a, condimentum pulvinar felis. In tincidunt quam malesuada, tempus quam sed, rutrum arcu. Mauris scelerisque ac leo id lacinia.",
                "office_id" => 3,
                "slug" => "inventory-system",
            ],
        ];
        foreach ($sections as $section) {
            Section::create($section);
        }
    }
}
