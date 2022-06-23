<?php

namespace Tests\Unit;

use App\Models\Category;
use App\Models\Farm;
use App\Models\Lang;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    public function testProductBelongsToCategory()
    {
        $product = Product::factory()->create();
        $category = Category::factory()->create();
        $product->category()->associate($category);

        $this->assertEquals($product->category->id, $category->id);

        $product->delete();
        $category->delete();
    }

    public function testProductBelongsToFarm()
    {
        $product = Product::factory()->create();
        $farm = Farm::factory()->create();
        $product->farm()->associate($farm);

        $this->assertEquals($product->farm->id, $farm->id);

        $product->delete();
        $farm->delete();
    }

    public function testProductBelongsToLang()
    {
        $product = Product::factory()->create();
        $lang = Lang::factory()->create();
        $product->lang()->associate($lang);

        $this->assertEquals($product->lang->id, $lang->id);

        $product->delete();
        $lang->delete();
    }
}
