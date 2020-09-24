<?php

namespace Tests\Feature\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
// use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Artisan;

class LoginTest extends TestCase
{
    public function testRequiresEmailAndLogin()
    {
        $req = $this->patch('api/login');
        // $this->json('PATCH', 'api/login')

        dd($req);
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
            'password' => bcrypt('password'),
        ]);

        $payload = ['email' => 'testlogin@mail.com', 'password' => 'passsword'];

        $this->withHeaders([
            'Content-Type' => 'Application/json',
        ])->json('PATCH', 'api/login', $payload)
            ->assertStatus(200)
            ->assertJsonStructure([
                // 'data' =>[
                //     // "status",
                // "message",
                // "code",
                // "user",
                // "token"
                // ]
            ]);

    }
}
