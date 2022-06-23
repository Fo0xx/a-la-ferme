<?php

namespace Tests\Feature;

use App\Models\Address;
use App\Models\Admin;
use App\Models\Farm;
use App\Models\Farm_details;
use App\Models\User;
use App\Models\Vote;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VoteControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testRetrievingAllVotes()
    {
        $user = User::factory()->create();
        $user2 = User::factory()->create();
        $adress = Address::factory()->create();
        $farm_details = Farm_details::factory()->create();

        $farm = Farm::factory()->create([
            'user_id' => $user->id,
            'address_id' => $adress->id,
            'farm_details_id' => $farm_details->id,
            ]);

        $vote = Vote::factory()->create([
            'user_id' => $user->id,
            'farm_id' => $farm->id,
            'vote' => 1
        ]);

        $vote2 = Vote::factory()->create([
            'user_id' => $user2->id,
            'farm_id' => $farm->id,
            'vote' => 2
        ]);
        
        $this->actingAs($user, 'user')->getJson('/api/votes')->assertStatus(200);
        $this->actingAs($user, 'user')->getJson('/api/votes?filter[id]=1050')->assertStatus(404);
        $this->actingAs($user, 'user')->getJson('/api/votes?filter[id]='.$vote->id)->assertStatus(200);
        $this->actingAs($user, 'user')->getJson('/api/votes?filter[user_id]='.$user->id)->assertStatus(200);
        $this->actingAs($user, 'user')->getJson('/api/votes?filter[farm_id]='.$farm->id)->assertStatus(200);
        $this->actingAs($user, 'user')->getJson('/api/votes?sort=id')->assertStatus(200);
        $this->actingAs($user, 'user')->getJson('/api/votes/'.$vote->id)->assertStatus(200);
        $this->actingAs($user, 'user')->getJson('/api/votes/'.$vote->id+2)->assertStatus(404);
        //A user can't access other user's votes
        $this->actingAs($user2, 'user')->getJson('/api/votes/' . $vote2->id, [
            'vote' => 2
        ])->assertStatus(403);

        $user->delete();
        $adress->delete();
        $farm_details->delete();
        $farm->delete();
        $vote->delete();
    }

    public function testUserCanVote() {
        $user = User::factory()->create();
        $adress = Address::factory()->create();
        $farm_details = Farm_details::factory()->create();
        $farm = Farm::factory()->create([
            'user_id' => $user->id,
            'address_id' => $adress->id,
            'farm_details_id' => $farm_details->id,
            ]);


        $response = $this->actingAs($user, 'user')->postJson('/api/votes', [
            'farm_id' => $farm->id,
            'vote' => 1
        ]);

        $response->assertStatus(201);
        $response->assertJson([
            'data' => [
                'user_id' => $user->id,
                'farm_id' => $farm->id,
                'vote' => 1
            ]
        ]);

        $response = $this->actingAs($user, 'user')->postJson('/api/votes', [
            'vote' => 2
        ])->assertStatus(404);

        $user->delete();
        $user->votes()->delete();
        $adress->delete();
        $farm->delete();
        $farm_details->delete();
    }

    public function testUserCanOnlyUpdateHisVote() {
        $user = User::factory()->create();
        $user2 = User::factory()->create();
        $adress = Address::factory()->create();
        $farm_details = Farm_details::factory()->create();

        $farm = Farm::factory()->create([
            'user_id' => $user->id,
            'address_id' => $adress->id,
            'farm_details_id' => $farm_details->id,
            ]);

        $vote = Vote::factory()->create([
            'user_id' => $user->id,
            'farm_id' => $farm->id,
            'vote' => 1
        ]);

        $vote2 = Vote::factory()->create([
            'user_id' => $user2->id,
            'farm_id' => $farm->id,
            'vote' => 1
        ]);

        // A user can only update his vote
        $this->actingAs($user, 'user')->putJson('/api/votes/' . $vote->id, [
            'vote' => 2
        ])->assertStatus(200);

        $this->actingAs($user, 'user')->putJson('/api/votes/' . $vote->id, [])->assertStatus(404);

        $this->actingAs($user2, 'user')->putJson('/api/votes/' . $vote2->id, [
            'vote' => 2
        ])->assertStatus(403);

        $user->delete();
        $user2->delete();
        $user->votes()->delete();
        $user2->votes()->delete();
        $adress->delete();
        $farm->delete();
        $farm_details->delete();
    }

    public function testUserCanDeleteHisVote() {
        $user = User::factory()->create();
        $adress = Address::factory()->create();
        $farm_details = Farm_details::factory()->create();
        $farm = Farm::factory()->create([
            'user_id' => $user->id,
            'address_id' => $adress->id,
            'farm_details_id' => $farm_details->id,
            ]);

        $vote = Vote::factory()->create([
            'user_id' => $user->id,
            'farm_id' => $farm->id,
            'vote' => 1
        ]);

        $response = $this->actingAs($user, 'user')->deleteJson('/api/votes/' . $vote->id);

        $response->assertStatus(200);

        $user->delete();
        $user->votes()->delete();
        $adress->delete();
        $farm->delete();
        $farm_details->delete();
    }

    public function testUserCannotDeleteAnotherVote() {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $adress = Address::factory()->create();
        $farm_details = Farm_details::factory()->create();
        $farm = Farm::factory()->create([
            'user_id' => $user1->id,
            'address_id' => $adress->id,
            'farm_details_id' => $farm_details->id,
            ]);

        $vote = Vote::factory()->create([
            'user_id' => $user1->id,
            'farm_id' => $farm->id,
            'vote' => 1
        ]);

        $response = $this->actingAs($user2, 'user')->deleteJson('/api/votes/' . $vote->id);

        $response->assertStatus(403);

        $user1->delete();
        $user2->delete();
        $vote->delete();
        $adress->delete();
        $farm->delete();
        $farm_details->delete();
    }

    /**
     * Test to check if an admin can delete any vote
     */
    public function testAdminCanDeletingVote() {
        $vote = Vote::factory()->create([
            'vote' => 1
        ]);

        $admin = Admin::factory()->create();

        // Admin can delete any vote that exists
        $response = $this->actingAs($admin, 'admin')->deleteJson('/api/votes/' . $vote->id)->assertStatus(200);
        dd($response->getContent());
        // Admin can't delete a vote that doesn't exist
        $this->actingAs($admin, 'admin')->deleteJson('/api/votes/' . $vote->id+1)->assertStatus(404);

        $vote->delete();
    }

    public function testAdminCanUpdateVotes() {
        $user = User::factory()->create();
        $adress = Address::factory()->create();
        $farm_details = Farm_details::factory()->create();
        $farm = Farm::factory()->create([
            'user_id' => $user->id,
            'address_id' => $adress->id,
            'farm_details_id' => $farm_details->id,
            ]);

        $vote = Vote::factory()->create([
            'user_id' => $user->id,
            'farm_id' => $farm->id,
            'vote' => 1
        ]);

        $admin = Admin::factory()->create();

        // Admin can update any vote that exists
        $this->actingAs($admin, 'admin')->putJson('/api/votes/' . $vote->id, [
            'vote' => 2
        ])->assertStatus(200);

        //Admin ca't update a vote that doesn't exist
        $this->actingAs($admin, 'admin')->putJson('/api/votes/' . $vote->id+1, [
            'vote' => 2
        ])->assertStatus(404);

        $user->delete();
        $user->votes()->delete();
        $adress->delete();
        $farm->delete();
        $farm_details->delete();
    }

}
