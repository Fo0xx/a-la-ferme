<?php

namespace Tests\Unit;

use App\Models\Address;
use App\Models\Country;
use App\Models\Currency;
use Tests\TestCase;

class CountryTest extends TestCase
{
    public function testCountryHasManyAddresses()
    {
        $country = Country::factory()->create();
        $address = Address::factory()->create();
        $country->addresses()->save($address);

        $this->assertEquals($country->addresses->count(), 1);

        $country->delete();
        $address->delete();
    }

    public function testCountryBelongsToCurrency()
    {
        $country = Country::factory()->create();
        $currency = Currency::factory()->create();
        $country->currency()->associate($currency);

        $this->assertEquals($country->currency->id, $currency->id);

        $country->delete();
        $currency->delete();
    }
}
