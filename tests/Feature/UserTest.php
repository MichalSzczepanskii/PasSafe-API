<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserTest extends TestCase
{
    use DatabaseMigrations;
    protected static $user;
    protected static $otherUser;

    protected function authenticate() {
        return JWTAuth::fromUser(self::$user);
    }

    protected function authResponse() {
        return $this
            ->withHeader('Authorization', 'Bearer ' . $this->authenticate());
    }

    protected function setUp(): void {
        parent::setUp();
        self::$user = User::create([
            'email'          => 'test@localhost',
            'password'       => Hash::make('root12'),
            'encryption_key' => Str::random(32),
        ]);

        self::$otherUser = User::create([
            'email'          => 'local@localhost',
            'password'       => Hash::make('root12'),
            'encryption_key' => Str::random(32),
        ]);
    }

    public function testUserCanSeeHisData() {
        $response = $this->authResponse()
            ->get(route('user.me'));

        $response->assertSuccessful()
            ->assertJsonFragment([
                'id' => self::$user->id,
                'email' => self::$user->email,
            ]);
    }

    public function testUserCannotSeeOthersData() {
        $response = $this->authResponse()
            ->get(route('user.me'));

        $response->assertSuccessful()
            ->assertJsonMissing([
                'id' => self::$otherUser->id,
                'email' => self::$otherUser->email
            ]);
    }

    public function testUserCanChangeHisPassword() {
        $response = $this->authResponse()
            ->post(route('user.change_password'), [
                'current_password' => 'root12',
                'new_password' => '12root',
                'new_password_confirmation' => '12root',
                'encryption_key' => Str::random(32)
            ]);

        $response->assertSuccessful();
    }
}
