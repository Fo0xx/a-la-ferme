<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    /**
     * A login user test (required field).
     *
     * @return void
     */
    public function testRequiresEmailAndLoginUser()
    {
        $this->json('POST', 'api/login')
            ->assertStatus(400)
            ->assertJson([
                'success' => false,
                'data' => [
                    'error' => 'Bad Request.',
                    'email' => 'The email field is required.',
                    'password' => 'The password field is required.'
                ]
            ]);
    }

    /**
     * A login admin test (required field).
     *
     * @return void
     */
    public function testRequiresEmailAndLoginAdmin()
    {
        $this->json('POST', 'api/loginadmin')
            ->assertStatus(400)
            ->assertJson([
                'success' => false,
                'data' => [
                    'error' => 'Bad Request',
                    'email' => 'The email field is required.',
                    'password' => 'The password field is required.'
                ],
                'message' => 'Bad Request.',
            ]);
    }

    /**
     * A login user test (authorised, is a user).
     *
     * @return void
     */
    public function testUserLoginsAuthorised()
    {
        $headers = ['Accept' => 'application/json'];

        //create a fake user and use it to login
        $user = User::factory()->create([
            'password' => Hash::make('password'),
        ]);

        $this->json('POST', 'api/login', [
            'email' => $user->email,
            'password' => 'password',
        ], $headers)
            ->assertStatus(404)
            ->assertJsonStructure([
                "success",
                "message",
                "data" => [
                    'error'
                ],
            ]);

        $user->delete();
    }

    /**
     * A login admin test (authorised, is a admin).
     *
     * @return void
     */
    public function testAdminLoginsAuthorised()
    {
        $headers = ['Accept' => 'application/json'];
        $adminTest = ['email' => 'falsetestlogin@admin.com', 'password' => 'admin123'];

        $this->json('POST', 'api/loginadmin', $adminTest, $headers)
            ->assertStatus(404)
            ->assertJsonStructure([
                "success",
                "message",
                "data" => [
                    'error'
                ],
            ]);

    }

    /**
     * A login user test (successfull).
     *
     * @return void
     */
    public function testUserLoginsSuccessfully()
    {
        User::create([
            'first_name' => 'Test',
            'last_name' => 'Login',
            'email' => 'testlogin@user.com',
            'password' => Hash::make('User123'),
            'role_id' => 2,
            'address_id' => 1
        ]);

        $headers = ['Accept' => 'application/json'];
        $userTest = ['email' => 'testlogin@user.com', 'password' => 'User123'];

        $this->json('POST', 'api/login', $userTest, $headers)
            ->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'data' => [
                    'token',
                    'id',
                    'first_name',
                    'last_name',
                    'email',
                    'role_id',
                    'address_id',
                    'created_at',
                    'updated_at'
                ],
                'message'
            ]);

        User::where('email', 'testlogin@user.com')->delete();
    }

    /**
     * A login admin test (successfull).
     *
     * @return void
     */
    public function testAdminLoginsSuccessfully()
    {
        $admin = Admin::factory()->create();

        $headers = ['Accept' => 'application/json'];
        $adminTest = ['email' => $admin->email, 'password' => 'password'];

        $this->json('POST', 'api/loginadmin', $adminTest, $headers)
            ->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'data' => [
                    'token',
                    'id',
                    'username',
                    'email',
                    'created_at',
                    'updated_at'
                ],
                'message'
            ]);

        $admin->delete();
    }
}
