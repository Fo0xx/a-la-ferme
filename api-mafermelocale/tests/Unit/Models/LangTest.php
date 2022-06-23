<?php

namespace Tests\Unit;

use App\Models\Category;
use App\Models\Farm;
use App\Models\Farm_details;
use App\Models\Lang;
use App\Models\Product;
use App\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LangTest extends TestCase
{

    use RefreshDatabase;

    public function testLangHasManyFarms()
    {
        $lang = Lang::factory()->create();
        $farm = Farm::factory()->create();
        $lang->farms()->save($farm);

        $this->assertEquals($lang->farms->count(), 1);

        $lang->delete();
        $farm->delete();
    }

    public function testLangHasManyCategories()
    {
        $lang = Lang::factory()->create();
        $category = Category::factory()->create();
        $lang->categories()->save($category);

        $this->assertEquals($lang->categories->count(), 1);

        $lang->delete();
        $category->delete();
    }

    public function testLangHasManyProducts()
    {
        $lang = Lang::factory()->create();
        $product = Product::factory()->create();
        $lang->products()->save($product);

        $this->assertEquals($lang->products->count(), 1);

        $lang->delete();
        $product->delete();
    }

    public function testLangHasManyRoles()
    {
        $lang = Lang::factory()->create();
        $role = Role::factory()->create();
        $lang->roles()->save($role);

        $this->assertEquals($lang->roles->count(), 1);

        $lang->delete();
        $role->delete();
    }

    public function testLangHasManyFarmDetails()
    {
        $lang = Lang::factory()->create();
        $farmDetails = Farm_details::factory()->create();
        $lang->farm_details()->save($farmDetails);

        $this->assertEquals($lang->farm_details->count(), 1);

        $lang->delete();
        $farmDetails->delete();
    }
}
