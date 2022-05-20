<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class FolderTest extends TestCase
{
    use RefreshDatabase;

    protected static $user;
    protected static $token;

    protected function setUp(): void {
        parent::setUp();
        self::$user = User::create([
            'email' => 'test@localhost',
            'password' => Hash::make('root12'),
            'encryption_key' => Str::random(32),
        ]);

        self::$token = JWTAuth::fromUser(self::$user);
    }


    public function testLoggedUserCanViewFolders()
    {
        $response = $this->json('GET',
            route('folders.index'),
            [],
            ['Authorization' => 'Bearer ' . self::$token]);
        $response
            ->assertSuccessful()
        ->assertJsonStructure([
            'id', 'name'
        ]);
    }

    public function testGuestCannotViewFolders() {
        $response = $this->json('GET',
            route('folders.index'),
            []);
        $response
            ->assertUnauthorized();
    }
}
