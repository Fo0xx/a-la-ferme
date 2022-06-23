<?php

namespace Tests\Unit;

use App\Models\Country;
use App\Models\Currency;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CurrencyTest extends TestCase
{

    use RefreshDatabase;

    public function testCurrencyHasManyCountries()
    {
        $currency = Currency::factory()->create();
        $country = Country::factory()->create();
        $currency->countries()->save($country);

        $this->assertEquals($currency->countries->count(), 1);

        $currency->delete();
        $country->delete();
    }

    public function testCurrencyHasManyProducts()
    {
        $currency = Currency::factory()->create();
        $product = Product::factory()->create();
        $currency->products()->save($product);

        $this->assertEquals($currency->products->count(), 1);

        $currency->delete();
        $product->delete();
    }
}
