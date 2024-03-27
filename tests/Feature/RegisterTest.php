<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_register_page_is_accesible(){

        $response=$this->get("/register");
        $response->assertStatus(200);
        $response->assertSeeText("Register");

    }

    public function test_new_user_can_register(){

        //assert page register
        $response=$this->get("/register");
        $response->assertStatus(200);
        $response->assertSeeText("Register");

        //input all field & hit register button
        $response=$this->post("/register", [
            "name" => "Jan",
            "email" => "jan3@gmail.com",
            "password" => "12345678",
            "password-confirm" => "12345678"
        ]);

        //check after register page
        $this->assertAuthenticated();
        $response->assertRedirect("/home");
        $response->assertSeeText("(USER)");

    }

}
