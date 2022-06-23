<?php

namespace Tests\Unit;

use App\Models\Address;
use App\Models\Country;
use App\Models\Farm;
use App\Models\Farm_details;
use App\Models\User;
use Tests\TestCase;

class AddressTest extends TestCase
{
    //Testing address belongsTO user
    public function testAddressBelongsToUser()
    {
        //test the belongsTo relationship from the address model
        $address = Address::factory()->create();
        $user = User::factory()->create();
        $address->user()->associate($user);

        $this->assertEquals($address->user->id, $user->id);

        $user->delete();
        $address->delete();
    }

    //Testing address belong to a country
    public function testAddressBelongsToCountry()
    {
    $address = Address::factory()
    ->for(Country::factory()->make([
        'currency_id' => 1,
        ]))
        ->create([
            'country_id' => 1,
        ]);

        $this->assertEquals(1, $address->country_id);
        
        $address->delete();
    }

    //Testing address belongsTo a farm
    public function testAddressBelongsToFarm()
    {
        //test the belongsTo relationship from the address model
        $address = Address::factory()->create();
        $farm = Farm::factory()->create(
            [
                'user_id' => 1,
                'address_id' => 2,
                'farm_details_id' => 3,
            ]
        );
        $address->farm()->associate($farm);

        $this->assertEquals($address->farm->id, $farm->id);

        $farm->delete();
        $address->delete();
    }
}
