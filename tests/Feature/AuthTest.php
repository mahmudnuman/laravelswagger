<?php 

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use App\Models\User;

class AuthTest extends TestCase
{
use RefreshDatabase;

/** @test */
public function user_can_login_with_valid_credentials()
{
$user = User::factory()->create([
'password' => Hash::make('password'),
]);

$response = $this->postJson('/api/login', [
'email' => $user->email,
'password' => 'password',
]);

$response->assertStatus(200)
->assertJson(['token' => true]);
}

/** @test */
public function user_cannot_login_with_invalid_credentials()
{
$user = User::factory()->create([
'password' => Hash::make('password'),
]);

$response = $this->postJson('/api/login', [
'email' => $user->email,
'password' => 'wrongpassword',
]);

$response->assertStatus(401)
->assertJson(['message' => 'Invalid Credentials']);
}


public function user_can_logout()
{
    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->postJson('/api/logout');

    $response->assertStatus(200)
        ->assertJson(['message' => 'Logged out']);
}
public function unauthenticated_user_cannot_logout()
{
$response = $this->postJson('/api/logout');

$response->assertStatus(401)
->assertJson(['message' => 'Unauthenticated']);
}
}