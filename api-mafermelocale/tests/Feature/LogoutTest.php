<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Admin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LogoutTest extends TestCase
{

    use RefreshDatabase;

     /**
     * A logout user test
     *
     * @return void
     */
    public function testUserIsLoggedOutProperly()
    {
        //make a user and log them in
        $user = User::factory()->create([
            'role_id' => 2,
        ]);
        
        $headers = ['Accept' => 'application/json'];
        $userTest = ['email' => $user->email, 'password' =>'password'];

        //log the user in and get the token
        $response = $this->json('POST', 'api/login', $userTest,  $headers)->assertStatus(200);
        $token = $response->json()['data']['token'];

        $header = ['Authorization' => "Bearer $token"];

        $this->json('POST', 'api/logout', $header)
            ->assertStatus(200)
            ->assertJson([
                "success" => true,
                "message" => "User Signed out.",
                "data" => null
            ]);

        $user->delete();
    }

    /**
     * A logout admin test
     *
     * @return void
     */
    public function testAdminIsLoggedOutProperly()
    {
        $admin = Admin::factory()->create();

        $headers = ['Accept' => 'application/json'];
        $adminTest = ['email' => $admin->email, 'password' => 'password'];

        $response = $this->json('POST', 'api/loginadmin', $adminTest, $headers)->assertStatus(200);
        $token = $response->json()['data']['token'];

        $header = ['Authorization' => "Bearer $token"];

        $this->json('POST', 'api/logoutadmin', $header)
            ->assertStatus(200)
            ->assertJson([
                "success" => true,
                "message" => "Admin signed out.",
                "data" => null
            ]);

        $admin->delete();
    }

    /**
     * A logout admin test and test access of files
     *
     * @return void
     */
    public function testAdminWithNullToken()
    {
        // Simulating login
        $admin = Admin::factory()->create();

        $this->getJson('api/users')->assertStatus(401);

        $admin->delete();
    }
}
