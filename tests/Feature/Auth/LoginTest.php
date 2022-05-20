<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    protected static $user;

    protected function setUp(): void {
        parent::setUp();
        self::$user = User::create([
            'email' => 'test@localhost',
            'password' => Hash::make('root12'),
            'encryption_key' => Str::random(32),
        ]);
    }



    public function testUserCanLoginWithValidCredentials() {
        $response = $this->json('POST', route('login'), [
            'email' => 'test@localhost',
            'password' => 'root12'
        ]);

        $response
            ->assertSuccessful()
            ->assertJsonStructure([
                'access_token', 'token_type', 'expires_in'
            ]);
    }

    public function testUserCannotLoginWithNotValidCredentials() {
        $response = $this->json('POST', route('login'), [
            'email' => 'admin@localhost',
            'password' => '123321'
        ]);

        $response
            ->assertUnauthorized()
            ->assertJsonStructure([
                'error'
            ]);
    }

    public function testUserCanLogout() {
        $token = JWTAuth::fromUser(self::$user);
        $response = $this->json('POST', route('logout'), [], ['Authorization' => 'Bearer ' . $token]);
        $response
            ->assertSuccessful()
            ->assertExactJson([
                'message' => 'Successfully logged out'
            ]);
    }

    public function testUserCanRefreshToken() {
        $token = JWTAuth::fromUser(self::$user);
        $response = $this->json('POST', route('refresh'), [], ['Authorization' => 'Bearer ' . $token]);

        $response
            ->assertSuccessful()
            ->assertJsonStructure([
                'access_token', 'token_type', 'expires_in'
            ]);
    }
}
