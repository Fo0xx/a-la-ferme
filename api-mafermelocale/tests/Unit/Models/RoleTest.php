<?php

namespace Tests\Unit;

use App\Models\Lang;
use App\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoleTest extends TestCase
{

    use RefreshDatabase;

    /**
     * Check if the Role model has a User relationship
     */
    public function testRoleHasUsers()
    {
        $role = Role::factory()
                ->hasUsers(3)
                ->create();

        $this->assertEquals($role->users->count(), 3);

        $role->users()->delete();
        $role->delete();
    }

    /**
     * Check if the Role model has a Lang relationship
     */
    public function testRoleHasLang()
    {
        $lang = Lang::factory()->make([
            'name' => 'Français',
        ]);

        $role = Role::factory()->make([
            'id' => 1,
            'name' => 'Client',
        ])->lang()->associate($lang);

        $this->assertEquals($role->lang->id, $lang->id);

        $role->lang()->delete();
        $role->delete();
    }
}
