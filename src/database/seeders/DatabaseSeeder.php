<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $location_data = [
            ["38", "District Office"],
            ["100", "Amelia Earhart"],
            ["101", "Canyon Crest"],
            ["102", "Edgemont"],
            ["103", "Provo Peaks"],
            ["104", "Franklin"],
            ["108", "Grandview"],
            ["118", "Lakeview"],
            ["120", "Provost"],
            ["122", "Rock Canyon"],
            ["123", "Spring Creek"],
            ["124", "Sunset View"],
            ["128", "Timpanogos"],
            ["132", "Wasatch"],
            ["134", "Westridge"],
            ["404", "Centennial Middle"],
            ["035", "Dixon"],
            ["555", "Slate Canyon"],
            ["408", "Shoreline Middle"],
            ["560", "Oak Springs"],
            ["590", "Vantage Point"],
            ["610", "Central Utah Enterprises"],
            ["610", "East Bay Post High"],
            ["641", "Preschool"],
            ["704", "Provo High"],
            ["712", "Timpview High"],
            ["730", "Independence High"],
            ["740", "Provo Adult Education"],
            ["818", "CLC"],
            ["1200", "Hillside"],
            ["1600", "Transportation"],
            ["1700", "Maintenance"],
            ["1896", "Aux Services"],
            ["1510", "Public Relations/Communications"],
            ["1897", "Technology"],
            ["510", "eSchool"]
        ];
        foreach ($location_data as $location) {
            // Insert location and get the inserted ID so we can seed test assets
            $locationId = DB::table('locations')->insertGetId([
                'site_number' => $location[0], // Insert site_number
                'display_name' => $location[1]
            ]);
        }


        $category_data = [
            "Building Automation",
            "Carpentry",
            "Ceilings",
            "Custodial",
            "Doors and Hardware",
            "Electrical",
            "Fire Protection",
            "Flooring",
            "Food Services",
            "Glass/Window Repair",
            "Grounds",
            "Heating/Ventilation/Air Conditioning",
            "Housekeeping",
            "Lighting",
            "Moving/Delivery",
            "Painting",
            "Pest Control",
            "Plumbing",
            "Roofing",
            "Vehicle Maintenance",
            "Wall Repair",
            "Hardscape",
            "Playground",
            "Site Work",
            "Other"
        ];

        $i = 1;
        foreach ($category_data as $category) {
            DB::table('asset_categories')->insert([
                'id' => $i,
                'display_name' => $category
            ]);
            $i++;
        }

        $company_data = [
            "Apple"
        ];
        $i = 1;
        foreach ($company_data as $company) {
            DB::table('asset_companies')->insert([
                'id' => $i,
                'name' => $company
            ]);
            $i++;
        }
    }
}
