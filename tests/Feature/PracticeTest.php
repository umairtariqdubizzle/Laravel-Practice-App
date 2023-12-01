<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use App\Models\User;

class PracticeTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    // public function test_example(): void
    // {
    //     $response = $this->get('/');

    //     $response->assertStatus(200);
    // }

    // public function test_create_user(): void {
    //     $user = User::factory()->create();
    //     $response = $this->get('/');
    //     $response->assertStatus(200);
    // }

    public function test_user_registration(): void
    {
        //Preparation
        $data = [
            'name' => 'umair', // Empty name to trigger the 'required' validation rule
            'email' => 'email@test.com', // Invalid email format
            'password' => 'password',
            'confirm_password' => 'password', // Mismatched passwords
        ];
        //Action
        $response = $this->postJson('/api/register', $data);

        //Assertion
        $response->assertStatus(201);
    }

    public function test_user_login(): void
    {
        // Create a user for testing
        $user = User::factory()->create([
            'email' => 'john@example.com',
            'password' => Hash::make('password'),
        ]);

        // Make a request to the login API
        $response = $this->postJson('/api/login', [
            'email' => 'john@example.com',
            'password' => 'password',
        ]);

        // dd($response->json());

        // Assert the response status
        // $response->assertStatus(200);

        $response->assertStatus(200)->assertJsonStructure([
            'success',
            'date' => [
                'token',
                'name',
            ],
            'message',
        ]);
    }
    public function test_get_user_details_with_token(): void
    {
        // Assuming you have a registered user with an associated token
        $user = User::factory()->create();
        $token = $user->createToken('test-token')->plainTextToken;

        // Hit the login endpoint to get the token
        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        // Assert the login was successful
        $response->assertStatus(200);

        // Now, use the obtained token to authenticate subsequent requests
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->getJson('/api/user');
        // dd($response->json());
        // Assert the response contains the user details
        $response->assertStatus(200)
            ->assertJson([
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                // Add other expected user details as needed
            ]);
    }
}
