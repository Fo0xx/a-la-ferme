<?php

namespace Tests\Unit;

use App\Models\Address;
use App\Models\Farm;
use App\Models\Farm_details;
use App\Models\Lang;
use App\Models\Product;
use App\Models\User;
use App\Models\Vote;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FarmTest extends TestCase
{

    use RefreshDatabase;

    public function testFarmBelongsToLang()
    {
        $farm = Farm::factory()->create();
        $lang = Lang::factory()->create();
        $farm->lang()->associate($lang);

        $this->assertEquals($farm->lang->id, $lang->id);

        $farm->delete();
        $lang->delete();
    }

    public function testFarmHasManyVotes()
    {
        $farm = Farm::factory()->create();
        $vote = Vote::factory()->create();
        $farm->votes()->save($vote);

        $this->assertEquals($farm->votes->count(), 1);

        $farm->delete();
        $vote->delete();
    }

    public function testFarmHasOneFarmDetails()
    {
        $farm = Farm::factory()->create();
        $farmDetails = Farm_details::factory()->create();
        $farm->farm_detail()->save($farmDetails);

        $this->assertEquals($farm->farm_detail->id, $farmDetails->id);

        $farm->delete();
        $farmDetails->delete();
    }

    public function testFarmHasOneAddress()
    {
        $farm = Farm::factory()->create();
        $address = Address::factory()->create();
        $farm->address()->save($address);

        $this->assertEquals($farm->address->id, $address->id);

        $farm->delete();
        $address->delete();
    }

    public function testFarmBelongsToUser() {
        $farm = Farm::factory()->create();
        $user = User::factory()->create();
        $farm->user()->associate($user);

        $this->assertEquals($farm->user->id, $user->id);

        $farm->delete();
        $user->delete();
    }

    public function testFarmHasManyProducts()
    {
        $farm = Farm::factory()->create();
        $product = Product::factory(5)->create();
        foreach ($product as $product) {
            $farm->products()->save($product);
        }

        $this->assertEquals($farm->products->count(), 5);

        $farm->delete();
        $product->delete();
    }
}
