<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    public function testsRegistersSuccessfully()
    {
        $payload = [
            'name' => 'John',
            'email' => 'john@toptal.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ];

       $req =  $this->post('api/register', $payload);
    //    dd($req);
       $req->assertStatus(200)
            ->assertJsonStructure([
                "status",
                "message",
                "code",
                "user",
                "token"
               
            ]);
    }

    public function testsRequiresPasswordEmailAndName()
    {
        $this->post('/api/register')
            ->assertStatus(422)
            ->assertJson([
                'name' => ['The name field is required.'],
                'email' => ['The email field is required.'],
                'password' => ['The password field is required.'],
            ]);
    }

    public function testsRequirePasswordConfirmation()
    {
        $payload = [
            'name' => 'John',
            'email' => 'john@toptal.com',
            'password' => 'toptal123',
        ];

        $this->post('/api/register', $payload)
            ->assertStatus(422)
            ->assertJson([
                'password' => ['The password confirmation does not match.'],
            ]);
    }
}
