<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class FolderTest extends TestCase
{
    use DatabaseMigrations;

    protected static $user;
    protected static $token;

    protected function setUp(): void {
        parent::setUp();
        $this->artisan('db:seed');

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
            ->assertSuccessful();
        $response->assertJsonStructure([[
            'id', 'name'
        ]]);
    }

    public function testGuestCannotViewFolders() {
        $response = $this->json('GET',
            route('folders.index'),
            []);
        $response
            ->assertUnauthorized();
    }
}
