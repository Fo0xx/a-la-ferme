<?php

namespace Tests\Unit;

use App\Models\Address;
use Faker\Factory;
use App\Models\Farm;
use App\Models\Role;
use App\Models\User;
use App\Models\Vote;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{

    use RefreshDatabase; // This trait will clear the database after each test run
    use WithFaker; // This trait will generate random data for us
    
    //Check if the User modal has a Role relationship
    public function testUserHasRoleRelationship()
    {
        $user = User::factory()->make();
        $user->role()->associate(Role::factory()->make(
            [
                'name' => 'client'
            ]
        ));

        $this->assertEquals($user->role->name, 'client');

        $user->role()->delete();
        $user->delete();
    }
    
    //Check if the User model has a Address relationship
    public function testUserHasOneAddress()
    {
        $user = User::factory()->create();
        $address = Address::factory()->create();
        $user->address()->save($address);

        $this->assertEquals($user->address->id, $address->id);

        $user->address()->delete();
    }

    //Check if the User model has a Vote relationship
    public function testUserHasVoteRelationship()
    {
        $user = User::factory()->create();

        $vote = Vote::factory()->make(
            [
                'user_id' => $user->id,
                'farm_id' => $this->faker->numberBetween(1, 10),
            ]
        );

        //associated the vote to the user
        $vote->user()->associate($user)->save();

        $this->assertEquals($user->votes->count(), 1);

        $user->votes()->delete();
        $user->delete();
    }

    //Check if the User model has a Farm relationship
    public function testUserHasFarmRelationship()
    {
        $user = User::factory()->make([
            'role_id' => 1
        ]);

        $farm = Farm::factory()->make([
            'user_id' => $user->id
        ]);

        $this->assertEquals($user->farm_id, $farm->id);

        $user->farm()->delete();
        $user->delete();
    }
}
