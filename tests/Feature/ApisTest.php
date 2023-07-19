<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ApisTest extends TestCase
{
    /// Auth

    /**
     *  Signin test.
     */
    public function test_signin(): void
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->post('/api/auth/login',
        ['email' => 'test@gmail.com',
         'password' => '123456'
        ]);

        $response->assertStatus(200);
    }

    /**
     *  Signup tests.
     */
    public function test_signup(): void
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->post('/api/auth/signup',
        [
         'name' => 'John',
         'email' => 'test777@gmail.com',
         'phone_number' => '1598788',
         'password' => '123456'
        ]);

        $response->assertStatus(201);
    }

    /**
     *  Get Bearer token.
     */
    private function get_bearer_token($email, $pass){
        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->post('/api/auth/login',
        ['email' => $email,
         'password' => $pass
        ]);

        return $response["access_token"];
    }

     /**
     *  Logout test.
     */
    public function test_logout(): void
    {
        $token = $this->get_bearer_token("test@gmail.com","123456");
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => "Bearer $token"
        ])->post('/api/auth/logout');

        $response->assertStatus(200);
    }

    /**
     *  Refresh token test.
     */
    public function test_refresh_token(): void
    {
        $token = $this->get_bearer_token("test@gmail.com","123456");
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => "Bearer $token"
        ])->post('/api/auth/refresh');

        $response->assertStatus(200);
    }

    /**
     *  Get me user info test.
     */
    public function test_me(): void
    {
        $token = $this->get_bearer_token("test@gmail.com","123456");
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => "Bearer $token"
        ])->post('/api/auth/me');

        $response->assertStatus(200);
    }

    /// Product Tests.

    /**
     *  Create product.
     */
    public function test_create_product(): void
    {
        $token = $this->get_bearer_token("test@gmail.com","123456");

        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => "Bearer $token"
        ])->post('/api/product',
        [
         'name' => 'Product',
         'description' => 'Product Desc'
        ]);

        $response->assertStatus(201);
    }

    /**
     *  Get products.
     */
    public function test_get_products(): void
    {
        $token = $this->get_bearer_token("test@gmail.com","123456");

        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => "Bearer $token"
        ])->get('/api/product');

        $response->assertStatus(200);
    }

    /**
     *  Edit product by product_id.
     */
    public function test_edit_product(): void
    {
        $token = $this->get_bearer_token("test@gmail.com","123456");

        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => "Bearer $token"
        ])->put('/api/product/1',[
            "name" => "test_prod",
            "description" => "test_desc"
        ]);

        $response->assertStatus(200);
    }

    /**
     *  Delete product by product_id.
     */
    public function test_delete_product(): void
    {
        $token = $this->get_bearer_token("test@gmail.com","123456");

        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => "Bearer $token"
        ])->delete('/api/product/1');

        $response->assertStatus(200);
    }

    /// Admin Test

    /**
     *  Admin get all users info test.
     */
    public function test_admin_get_users_info(): void
    {
        $token = $this->get_bearer_token("admin@gmail.com","123456");

        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => "Bearer $token"
        ])->get('/api/admin/users');

        $response->assertStatus(200);
    }
}
