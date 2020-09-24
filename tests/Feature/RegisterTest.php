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
        $this->post('/api/register', [], ['Accept' => 'aplication/json', 'Content-Type' => 'aplication/json'])
            ->assertStatus(422)
            ->assertJsonStructure([
                "message",
                "errors" => [
                    "email",
                    "password",
                    "name"
                ]
            ]);
    }

    public function testsRequirePasswordConfirmation()
    {
        $payload = [
            'name' => 'John',
            'email' => 'john@toptal.com',
            'password' => 'toptal123',
        ];

        $this->post('/api/register', $payload, ['Accept' => 'aplication/json', 'Content-Type' => 'aplication/json'])
            ->assertStatus(422)
            ->assertJsonStructure([               
                "message",
                "errors" => [
                    'password'
                ]
            ]);
    }
}
