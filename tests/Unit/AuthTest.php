<?php

namespace Tests\Unit;

use App\Models\Tag;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_register_creates_new_user_and_returns_token()
    {
        $data = [
            'name' => 'Fulano de Tal',
            'email' => 'fulano@example.com',
            'password' => 'senha123',
        ];

        $response = $this->postJson('/api/register', $data);

        $response->assertStatus(200)
                 ->assertJsonStructure(['token']);
        
        $this->assertDatabaseHas('users', [
            'email' => 'fulano@example.com',
        ]);
    }

    public function test_login_returns_token_for_valid_credentials()
    {
        $data = [
            'name' => 'Fulano de tal',
            'email' => 'fulano@example.com',
            'password' => 'senha123',
        ];

        $this->postJson('/api/register', $data);

        $response = $this->postJson('/api/login', $data);

        $response->assertStatus(200)
                 ->assertJsonStructure(['token']);
    }

    public function test_login_fails_with_invalid_credentials()
    {
        $data = [
            'email' => 'fulano@example.com',
            'password' => 'wrongpassword',
        ];

        $response = $this->postJson('/api/login', $data);

        $response->assertStatus(401)
                 ->assertJson(['error' => 'Credenciais inválidas']);
    }

    public function test_logout_logs_user_out_and_deletes_token()
    {
        $data = [
            'name' => 'Fulano de Tal',
            'email' => 'fulano@example.com',
            'password' => 'senha123',
        ];

        $response = $this->postJson('/api/register', $data);
        $token = $response->json('token');  

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
                        ->postJson('/api/logout');

        $response->assertStatus(200)
                ->assertJson(['message' => 'Desconectado com sucesso']);

        $user = User::where('email', 'fulano@example.com')->first();
        $this->assertCount(0, $user->tokens);
    }

    public function test_access_protected_route_requires_authentication()
    {
        $data = [
            'name' => 'Fulano de Tal',
            'email' => 'fulano@example.com',
            'password' => 'senha123',
        ];
    
        $response = $this->postJson('/api/register', $data);

        $response = $this->getJson('/api/user/'.User::first()->id.'/show');

        $response->assertStatus(401)
                 ->assertJson(['message' => 'Unauthenticated.']);
    }

    public function test_access_protected_route_with_valid_token()
    {
        $data = [
            'name' => 'Fulano de Tal',
            'email' => 'fulano@example.com',
            'password' => 'senha123',
        ];

        $response = $this->postJson('/api/register', $data);
 
        $response->assertStatus(200);
        $token = $response->json('token');
        $this->assertNotNull($token, 'Token is null');

        $tags = Tag::factory(1)->create();
    
        $postData = [
            'content' => 'Test content',
            'user_id' => User::first()->id,  
            'tags' => [1],
        ];
    
        // Faz a requisição para criar o post
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
                         ->postJson('/api/post/store', $postData);
    
        // Verifica se a resposta foi bem-sucedida
        $response->assertStatus(201);
    
        // Verifica se o post foi realmente criado no banco de dados
        $this->assertDatabaseHas('posts', [
            'content' => 'Test content',
            'user_id' => User::first()->id,
        ]);
    
        // Adicionalmente, podemos verificar se o post foi criado corretamente
        $post = \App\Models\Post::where('content', 'Test content')->first();
        $this->assertNotNull($post, 'Post was not created');
        $this->assertEquals($post->user_id, User::first()->id, 'User ID does not match');
    }
}
