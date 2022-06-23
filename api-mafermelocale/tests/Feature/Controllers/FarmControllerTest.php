<?php

namespace Tests\Feature;

use App\Models\Address;
use App\Models\Admin;
use App\Models\Farm;
use App\Models\Farm_details;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class FarmControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function testRetrievingAllFarms()
    {
        $admin = Admin::factory()->create();
        $user = User::factory()->create();
        $user->role()->associate(Role::where('name', 'Agriculteur')->first());
        $address = Address::factory()->create();
        $farm_details = Farm_details::factory()->create();
        $farm = Farm::factory(5)->create(
            [
                'user_id' => $admin->id,
                'address_id' => $address->id,
                'farm_details_id' => $farm_details->id,
            ]
        );

        $this->actingAs($admin, 'admin')->getJson('/api/farms')->assertStatus(200);
        $this->actingAs($admin, 'admin')->getJson('/api/farms?filter[name]='.$farm->first()->name)->assertStatus(200);
        $this->actingAs($admin, 'admin')->getJson('/api/farms?filter[address.postcode]='.$address->postcode)->assertStatus(200);
        $this->actingAs($admin, 'admin')->getJson('/api/farms?filter[address.city]='.$address->city)->assertStatus(200);
        $this->actingAs($admin, 'admin')->getJson('/api/farms?sort=name')->assertStatus(200);
        $this->actingAs($admin, 'admin')->getJson('/api/farms?include=address')->assertStatus(200);

        $this->actingAs($admin, 'admin')->getJson('/api/farms?filter[name]=geerhhe')->assertStatus(404);
        $this->actingAs($admin, 'admin')->getJson('/api/farms?filter[address.postcode]=geerhhe')->assertStatus(404);
        $this->actingAs($admin, 'admin')->getJson('/api/farms?filter[address.city]=geerhhe')->assertStatus(404);

        //testing the show method
        $this->actingAs($admin, 'admin')->getJson('/api/farms/'.$farm->first()->id)->assertStatus(200);
        $this->actingAs($admin, 'admin')->getJson('/api/farms/'.$farm->first()->id+6)->assertStatus(404);
    }

    public function testAFarmerCanCreateAFarm() {
        $user = User::factory()->create();
        $user->role()->associate(Role::where('name', 'Agriculteur')->first());

        $address = Address::factory()->create();
        $farm_details = Farm_details::factory()->create();
        Storage::fake('avatars');
        $file = UploadedFile::fake()->image('avatar.jpg');

        $this->actingAs($user, 'user')->postJson('/api/farms', [
            'name' => $this->faker()->name(),
            'short_description' => $this->faker()->text(20),
            'farm_image' => $file,
            'address_id' => $address->id,
            'farm_details_id' => $farm_details->id,
            'user_id' => $user->id,
        ])->assertStatus(201);

        // Missing a required field should return a 400 error
        $this->actingAs($user, 'user')->postJson('/api/farms', [
            'name' => $this->faker()->name(),
            'address_id' => $address->id,
            'farm_details_id' => $farm_details->id,
            'user_id' => $user->id,
        ])->assertStatus(400);

        //The address is not in the database
        $this->actingAs($user, 'user')->postJson('/api/farms', [
            'name' => $this->faker()->name(),
            'short_description' => $this->faker()->text(20),
            'farm_image' => $file,
            'address_id' => $address->id + 1,
            'farm_details_id' => $farm_details->id,
            'user_id' => $user->id,
        ])->assertStatus(404);

        $user->delete();
        $user->farm()->delete();
        $address->delete();
        $farm_details->delete();
    }

    public function testAFarmerCanUpdateHisFarm() {
        $user = User::factory()->create();
        $user->role()->associate(Role::where('name', 'Agriculteur')->first());

        $address = Address::factory()->create();
        $farm_details = Farm_details::factory()->create();
        Storage::fake('avatars');
        $file = UploadedFile::fake()->image('avatar.jpg');

        $farm = Farm::factory()->create([
            'user_id' => $user->id,
            'address_id' => $address->id,
            'farm_details_id' => $farm_details->id,
        ]);

        $this->actingAs($user, 'user')->putJson('/api/farms/' . $farm->id, [
            'name' => $this->faker()->name(),
            'short_description' => $this->faker()->text(20),
            'user_id' => $user->id,
            'farm_image' => $file,
        ])->assertStatus(200);

        //The farm does not exist
        $this->actingAs($user, 'user')->putJson('/api/farms/' . $farm->id + 6, [
            'name' => $this->faker()->name(),
            'short_description' => $this->faker()->text(20),
            'user_id' => $user->id,
        ])->assertStatus(404);

        $user->delete();
        $user->farm()->delete();
        $address->delete();
        $farm_details->delete();
    }

    public function testAFarmerCanDeleteHisFarm() {
        $user = User::factory()->create();
        $user->role()->associate(Role::where('name', 'Agriculteur')->first());

        $address = Address::factory()->create();
        $farm_details = Farm_details::factory()->create();

        $farm = Farm::factory()->create([
            'user_id' => $user->id,
            'address_id' => $address->id,
            'farm_details_id' => $farm_details->id,
        ]);

        // The farm exist
        $this->actingAs($user, 'user')->deleteJson('/api/farms/' . $farm->id)->assertStatus(200);

        //The farm does not exist
        $this->actingAs($user, 'user')->deleteJson('/api/farms/' . $farm->id + 6)->assertStatus(404);

        //Not the owner of the farm
        $user2 = User::factory()->create();
        $user2->role()->associate(Role::where('name', 'Agriculteur')->first());
        $farm2 = Farm::factory()->create([
            'user_id' => $user2->id,
            'address_id' => $address->id,
            'farm_details_id' => $farm_details->id,
        ]);

        $this->actingAs($user2, 'user')->deleteJson('/api/farms/' . $farm2->id)->assertStatus(403);

        $user->delete();
        $user->farm()->delete();
        $address->delete();
        $farm_details->delete();
    }

    public function testUserCannotCreateAFarm() {
        $user = User::factory()->create();
        $user->role()->associate(Role::where('name', 'Utilisateur')->first());

        $address = Address::factory()->create();
        $farm_details = Farm_details::factory()->create();
        Storage::fake('avatars');
        $file = UploadedFile::fake()->image('avatar.jpg');

        $response = $this->postJson('/api/farms', [
            'name' => $this->faker()->name(),
            'short_description' => $this->faker()->text(20),
            'farm_image' => $file,
            'address_id' => $address->id,
            'farm_details_id' => $farm_details->id,
            'user_id' => $user->id,
        ]);

        $response->assertStatus(401);

        $user->delete();
        $address->delete();
        $farm_details->delete();
    }

    public function testAdminCanDeleteAnyFarm() {
        $admin = Admin::factory()->create();
        $user = User::factory()->create();
        $user->role()->associate(Role::where('name', 'Agriculteur')->first());

        $address = Address::factory()->create();
        $farm_details = Farm_details::factory()->create();

        $farm = Farm::factory()->create([
            'user_id' => $user->id,
            'address_id' => $address->id,
            'farm_details_id' => $farm_details->id,
        ]);

        $response = $this->actingAs($admin, 'admin')->deleteJson('/api/farms/' . $farm->id);

        $response->assertStatus(200);

        $admin->delete();
        $user->delete();
        $user->farm()->delete();
        $address->delete();
        $farm_details->delete();
    }

    public function testAdminCanUpdateAnyFarm() {
        $admin = Admin::factory()->create();
        $user = User::factory()->create();
        $user->role()->associate(Role::where('name', 'Agriculteur')->first());

        $address = Address::factory()->create();
        $farm_details = Farm_details::factory()->create();
        Storage::fake('avatars');
        $file = UploadedFile::fake()->image('avatar.jpg');

        $farm = Farm::factory()->create([
            'user_id' => $user->id,
            'address_id' => $address->id,
            'farm_details_id' => $farm_details->id,
        ]);

        $response = $this->actingAs($admin, 'admin')->putJson('/api/farms/' . $farm->id, [
            'name' => $this->faker()->name(),
            'short_description' => $this->faker()->text(20),
            'user_id' => $user->id,
        ]);

        $response->assertStatus(200);

        $admin->delete();
        $user->delete();
        $user->farm()->delete();
        $address->delete();
        $farm_details->delete();
    }
}
