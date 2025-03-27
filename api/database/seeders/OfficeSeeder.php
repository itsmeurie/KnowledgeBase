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
            [
                'name' => "Sangguniang Panlungsod ng Baguio",
                'code' => "SP"
            ],
            [
                'name' => "City Human Resource Management Office",
                'code' => "CHRMO"
            ],
            [
                'name' => "City General Services Office",
                'code' => "CGSO"
            ],
            [
                'name' => "City Building and Architecture Office",
                'code' => "CBAO"
            ],
            [
                'name' => "City Planning, Development, and Sustainability Office",
                'code' => "CPDSO"
            ],
            [
                'name' => "City Accounting Office",
                'code' => "CACO"
            ],
            [
                'name' => "City Assessor's Office",
                'code' => "CASO"
            ],
            [
                'name' => "City Budget Office",
                'code' => "CBO"
            ],
            [
                'name' => "City Treasurer's Office",
                'code' => "CTO"
            ],
            [
                'name' => "City Civil Registry Office",
                'code' => "CCRO"
            ],
            [
                'name' => "City Legal Office",
                'code' => "CLO"
            ],
            [
                'name' => "City Disaster Risk Reduction and Management Office",
                'code' => "CDRRMO"
            ],
            [
                'name' => "City Veterinary and Agriculture Office",
                'code' => "CVAO"
            ],
            [
                'name' => "City Social Welfare and Development Office",
                'code' => "CSWDO"
            ],
            [
                'name' => "City Health Services Office",
                'code' => "CHSO"
            ],
            [
                'name' => "City Environment and Parks Management  Office",
                'code' => "CEPMO"
            ],
            [
                'name' => "City Engineering Office",
                'code' => "CEO"
            ],
            [
                'name' => "Baguio City Police Office",
                'code' => "BCPO"
            ],
            [
                'name' => "Bureau of Fire Protection",
                'code' => "BFP"
            ],
            [
                'name' => "Bureau of Jail Management And Penology (Female)",
                'code' => "BJMP(F)"
            ],
            [
                'name' => "Bureau of Jail Management And Penology (Male)",
                'code' => "BJMP(M)"
            ],
            [
                'name' => "Commission on Audit",
                'code' => "COA"
            ],
            [
                'name' => "Department of Education",
                'code' => "DepEd"
            ],
            [
                'name' => "Municipal Trial Court",
                'code' => "MTC"
            ],
            [
                'name' => "Parole",
                'code' => "P"
            ],
            [
                'name' => "Prosecutor's Office",
                'code' => "PO"
            ],
            [
                'name' => "Public Attorney's office",
                'code' => "PAO"
            ],
            [
                'name' => "Regional Trial Court",
                'code' => "RTC"
            ],
            [
                'name' => "DILG-Baguio City Field Office",
                'code' => "DILG-BCFO"
            ],
        ];


        foreach($offices as $office){
            Office::create($office);
        }
    }
}
