<?php

namespace Tests\Feature;

use App\Http\Resources\EntryCollection;
use App\Models\Entry;
use App\Models\Folder;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class EntryTest extends TestCase
{
    use DatabaseMigrations;
    protected static $user;
    protected static $otherUser;
    protected static $userEntry;
    protected static $otherUserEntry;

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
            'email' => 'test@localhost',
            'password' => Hash::make('root12'),
            'encryption_key' => Str::random(32),
        ]);

        self::$otherUser = User::create([
            'email' => 'local@localhost',
            'password' => Hash::make('root12'),
            'encryption_key' => Str::random(32),
        ]);

        $folder = Folder::create(['name' => 'test']);

        self::$userEntry = Entry::create([
            'name' => 'test',
            'login' => 'test',
            'password' => 'test',
            'site' => 'test',
            'user_id' => self::$user->id,
            'folder_id' => $folder->id
        ]);

        self::$otherUserEntry = Entry::create([
            'name' => 'testowy',
            'login' => 'testowy',
            'password' => 'testowy',
            'site' => 'testowy',
            'user_id' => self::$otherUser->id,
            'folder_id' => $folder->id
        ]);
    }



    public function testUserCanShowHisEntries()
    {
        $response = $this->authResponse()
            ->get(route('entries.index'));

        $response->assertSuccessful()
            ->assertJsonStructure([
                [
                    'id',
                    'login',
                    'password',
                    'site',
                    'description',
                    'user' => ['id', 'email'],
                    'folder' => ['id', 'name']]
            ])
            ->assertJsonFragment([
               'id' => self::$userEntry->id
            ]);
    }

    public function testUserCannotShowHisEntries() {
        $response = $this->authResponse()
            ->get(route('entries.index'));

        $response->assertSuccessful()
            ->assertJsonMissing([
            'id' => self::$otherUserEntry->id
        ]);
    }


    public function testUserCanDeleteHisEntry() {
        $response = $this->authResponse()
            ->delete(route('entries.remove', self::$userEntry));

        $response->assertSuccessful();
    }

    public function testUserCannotDeleteOtherEntries() {
        $response = $this->authResponse()
            ->delete(route('entries.remove', self::$otherUserEntry));

        $response->assertForbidden();
    }
}
