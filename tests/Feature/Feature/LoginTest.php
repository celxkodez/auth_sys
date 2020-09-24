<?php

namespace Tests\Feature\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
// use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;

class LoginTest extends TestCase
{
    public function testRequiresEmailAndLogin()
    {
        $req = $this->patch('api/login');
        $req->assertStatus(401)
            ->assertJsonStructure([
                "status",
                "code",
                "message",
                "description"
            ]);
    }


    public function testUserLoginsSuccessfully()
    {
        $user = factory(User::class)->create([
            'name' => 'test name',
            'email' => 'testlogin@mail.com',
            'password' => Hash::make('password'),
        ]);

        $payload = ['email' => 'testlogin@mail.com', 'password' => 'password'];

        $req = $this->patch('api/login', $payload);

        $req->assertStatus(200)
            ->assertJsonStructure([
                
                "status",
                "message",
                "code",
                "user",
                "token"
                
            ]);

    }
}
