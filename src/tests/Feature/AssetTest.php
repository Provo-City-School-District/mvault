<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\User;
use App\Models\Asset;

class AssetTest extends TestCase
{
    public function test_create_asset()
    {
        $asset = Asset::factory()->create();
        $this->assertModelExists($asset);

        $asset->delete();
        $this->assertModelMissing($asset);
    }
}
