<?php

namespace Tests\Unit;

use App\Models\Farm;
use App\Models\Farm_details;
use App\Models\Lang;
use Tests\TestCase;

class FarmDetailsTest extends TestCase
{
    public function testFarmDetailsBelongsToFarm()
    {
        $farmDetails = Farm_details::factory()->create();
        $farm = Farm::factory()->create();
        $farmDetails->farm()->associate($farm);

        $this->assertEquals($farmDetails->farm->id, $farm->id);

        $farm->delete();
        $farmDetails->delete();
    }

    public function testFarmDetailsBelongsToLang()
    {
        $farmDetails = Farm_details::factory()->create();
        $lang = Lang::factory()->create();
        $farmDetails->lang()->associate($lang);

        $this->assertEquals($farmDetails->lang->id, $lang->id);

        $farmDetails->delete();
        $lang->delete();
    }
}
