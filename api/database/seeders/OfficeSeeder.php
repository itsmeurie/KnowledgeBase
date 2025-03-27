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
                'code' => "CMO",
                'description' => "Short description for City Mayor's Office."
            ],
            [
                'name' => "City Administrator's Office",
                'code' => "CADMO",
                'description' => "Oversees the day-to-day administrative operations of the city government."
            ],
            [
                'name' => "Sangguniang Panlungsod ng Baguio",
                'code' => "SP",
                'description' => "The legislative body responsible for creating local policies and ordinances."
            ],
            [
                'name' => "City Human Resource Management Office",
                'code' => "CHRMO",
                'description' => "Manages personnel recruitment, benefits, and development programs for city employees."
            ],
            [
                'name' => "City General Services Office",
                'code' => "CGSO",
                'description' => "Handles procurement, asset management, and general support services of the city government."
            ],
            [
                'name' => "City Building and Architecture Office",
                'code' => "CBAO",
                'description' => "Regulates building construction and ensures compliance with architectural and zoning standards."
            ],
            [
                'name' => "City Planning, Development, and Sustainability Office",
                'code' => "CPDSO",
                'description' => "Formulates and implements development plans to ensure sustainable urban growth."
            ],
            [
                'name' => "City Accounting Office",
                'code' => "CACO",
                'description' => "Responsible for financial reporting and auditing of city government transactions."
            ],
            [
                'name' => "City Assessor's Office",
                'code' => "CASO",
                'description' => "Conducts property assessments for taxation purposes."
            ],
            [
                'name' => "City Budget Office",
                'code' => "CBO",
                'description' => "Prepares and oversees the city’s annual budget and financial planning."
            ],
            [
                'name' => "City Treasurer's Office",
                'code' => "CTO",
                'description' => "Manages city revenues, tax collection, and financial disbursements."
            ],
            [
                'name' => "City Civil Registry Office",
                'code' => "CCRO",
                'description' => "Handles registration of births, marriages, deaths, and other civil records."
            ],
            [
                'name' => "City Legal Office",
                'code' => "CLO",
                'description' => "Provides legal assistance and ensures compliance with laws in city government operations."
            ],
            [
                'name' => "City Disaster Risk Reduction and Management Office",
                'code' => "CDRRMO",
                'description' => "Develops and implements disaster preparedness and response programs."
            ],
            [
                'name' => "City Veterinary and Agriculture Office",
                'code' => "CVAO",
                'description' => "Oversees veterinary services, livestock health, and agricultural development programs."
            ],
            [
                'name' => "City Social Welfare and Development Office",
                'code' => "CSWDO",
                'description' => "Provides social services and assistance programs for disadvantaged communities."
            ],
            [
                'name' => "City Health Services Office",
                'code' => "CHSO",
                'description' => "Manages public health programs, medical services, and disease prevention initiatives."
            ],
            [
                'name' => "City Environment and Parks Management Office",
                'code' => "CEPMO",
                'description' => "Responsible for environmental protection, waste management, and park maintenance."
            ],
            [
                'name' => "City Engineering Office",
                'code' => "CEO",
                'description' => "Handles infrastructure projects, road maintenance, and public works."
            ],
            [
                'name' => "Baguio City Police Office",
                'code' => "BCPO",
                'description' => "Maintains peace and order through law enforcement and crime prevention efforts."
            ],
            [
                'name' => "Bureau of Fire Protection",
                'code' => "BFP",
                'description' => "Provides fire prevention, suppression, and emergency response services."
            ],
            [
                'name' => "Bureau of Jail Management And Penology (Female)",
                'code' => "BJMP(F)",
                'description' => "Manages detention facilities and rehabilitation programs for female inmates."
            ],
            [
                'name' => "Bureau of Jail Management And Penology (Male)",
                'code' => "BJMP(M)",
                'description' => "Oversees detention facilities and rehabilitation programs for male inmates."
            ],
            [
                'name' => "Commission on Audit",
                'code' => "COA",
                'description' => "Ensures transparency and accountability in government financial transactions."
            ],
            [
                'name' => "Department of Education",
                'code' => "DepEd",
                'description' => "Supervises public education, curriculum implementation, and teacher development."
            ],
            [
                'name' => "Municipal Trial Court",
                'code' => "MTC",
                'description' => "Handles minor civil and criminal cases within the city’s jurisdiction."
            ],
            [
                'name' => "Parole",
                'code' => "P",
                'description' => "Administers parole and probation programs for rehabilitating offenders."
            ],
            [
                'name' => "Prosecutor's Office",
                'code' => "PO",
                'description' => "Handles criminal prosecutions and legal proceedings for the city."
            ],
            [
                'name' => "Public Attorney's Office",
                'code' => "PAO",
                'description' => "Provides free legal assistance to indigent individuals."
            ],
            [
                'name' => "Regional Trial Court",
                'code' => "RTC",
                'description' => "Handles major civil and criminal cases at the regional level."
            ],
            [
                'name' => "DILG-Baguio City Field Office",
                'code' => "DILG-BCFO",
                'description' => "Ensures local government units comply with national policies and programs."
            ]
        ];


        foreach($offices as $office){
            Office::create($office);
        }
    }
}
