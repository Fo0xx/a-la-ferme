<?php

namespace Tests\Unit;

use App\Models\Category;
use App\Models\Lang;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryTest extends TestCase
{

    use RefreshDatabase;

    public function testCategoryHasManyProducts()
    {
        $category = Category::factory()->create();
        $product = Product::factory()->create();
        $category->products()->save($product);

        $this->assertEquals($category->products->count(), 1);
    }

    public function testCategoryBelongsToLang()
    {
        $category = Category::factory()->create();
        $lang = Lang::factory()->create();
        $category->lang()->associate($lang);

        $this->assertEquals($category->lang->id, $lang->id);
    }
}
