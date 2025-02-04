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
            ["408", "Dixon"],
            ["555", "Slate Canyon"],
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
            // Original code. Insert location
            // DB::table('locations')->insert([
            //     'site_number' => $location[0],
            //     'display_name' => $location[1]
            // ]); 
            // Insert location and get the inserted ID so we can seed test assets
            $locationId = DB::table('locations')->insertGetId([
                'site_number' => $location[0], // Insert site_number
                'display_name' => $location[1]
            ]);
            // Insert asset for each location
            for ($i = 1; $i < 10; $i++) {
                DB::table('assets')->insert([
                    'serial' => Str::random(10),
                    'barcode' => Str::random(10),
                    'company' => 'Company ' . chr(65 + $i),
                    'model' => 'Model ' . chr(88 + $i),
                    'site' => $locationId,
                    'room' => 'Room ' . (100 + $i),
                    //'category' => 'Category ' . chr(65 + $i),
                    'purchase_date' => now(),
                    'projected_eol_date' => now()->addDays(10),
                    'last_validated' => now(),
                ]);
            }
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
            "Wall Repair"
        ];

        $i = 1;
        foreach ($category_data as $category) {
            DB::table('asset_categories')->insert([
                'id' => $i,
                'display_name' => $category
            ]);
            $i++;
        }
    }
}
