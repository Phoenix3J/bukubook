<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_login_page_is_accessible(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200); //sukses ke halaman login
        $response->assertSeeText("Email Address"); //ada input email address
        $response->assertSeeText("Password"); //ada input password
    }

    //Case 1
    public function test_admin_can_login_to_app()
    {
        $response = $this->post("/login", [
            "email" => "admin@bukubook.com",
            "password" => "4dm1n"
        ]);

        //berhasil dapat response
        $this->assertAuthenticated();
        //diarahkan ke halaman home
        $response->assertRedirect("/home");
        //di halaman home ada welcome admin
        $responseHome= $this->get("/home");
        $responseHome->assertSeeText("ADMIN BUKUBOOK (ADMIN)");
    }


    //Case 2
    public function test_logged_in_user_can_logout()
    {
        //login admin
        $response = $this->post("/login", [
            "email" => "admin@bukubook.com",
            "password" => "4dm1n"
        ]);
        //assert authenticated
        $this->assertAuthenticated();
        //buat request get ke /home
        $response->assertRedirect("/home");
        $responseHome= $this->get("/home");
        $responseHome->assertSeeText("ADMIN BUKUBOOK (ADMIN)");

        //buat request method post ke /logout
        $response = $this->post("/logout");

        //assert redirect ke halaman login
        $responseHome = $this->get("/home");
        $responseHome -> assertRedirect("/login"); //validasi bahwa sudah ke halaman /login

    }




}
