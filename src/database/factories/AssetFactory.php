<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

use App\Models\Location;
use App\Models\AssetCategory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class AssetFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'site' => Location::where('display_name', 'Dixon')->first()->id,
            'room' => null,
            'category' => AssetCategory::where('display_name', 'Flooring')->first()->id,
            'name' => 'Test Asset',
            'company' => 'Apple',
            'model' => 'iPhone 17 Pro',
            'serial' => 'JFSLKDFJS3042',
            'barcode' => 'NA',
            'purchase_price' => '999.00',
            'purchase_date' => now(),
            'projected_eol_date' => now()->addYears(10),
            'replacement_price' => '1000.00',
            'description' => 'phone',
            'last_validated' => DB::raw('TIMESTAMP(0)')
        ];
    }
}
