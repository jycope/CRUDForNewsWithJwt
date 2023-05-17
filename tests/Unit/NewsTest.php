<?php

namespace Tests\Unit;

use App\Models\News;
use App\Models\User;
use Tests\TestCase;
use Faker\Generator as Faker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class NewsTest extends TestCase
{    
    use RefreshDatabase;

    private function getTokenOfUser()
    {
        $user = User::factory()->state(['password' => bcrypt('password')])->create();
        $userArray = $user->toArray();
        $userArray['password'] = 'password';
    
        $token = auth()->attempt($userArray);

        return $token;
    }
    
    public function testUserLoginAfterRegistration()
    {
        $faker = app(Faker::class);
        $name = $faker->name;
        $email = $faker->unique()->safeEmail;
        $password = bcrypt('password');
        
        $responseRegister = $this->post('api/register', [
            'name' => $name,
            'email' => $email, 
            'password' => $password
        ]);
    
        $responseRegister->assertStatus(200);
        $responseRegister->assertJsonStructure([
            'message'
        ]);

        $data = [
            'name' => $name,
            'email' => $email, 
            'password' => $password
        ];

        $responseLogin = $this->post('api/login', $data);

        $responseLogin->assertStatus(200);
        $responseLogin->assertJsonStructure([
            'access_token'
        ]);
    }
    
    public function testCreateNews()
    {
        $data = [
            'title' => 'title',
            'content' => 'content',
            'token' => $this->getTokenOfUser() 
        ];

        $response = $this->post('api/news', $data);
    
        $response->assertStatus(200);
        $response->assertSeeText([
            'Новость создана'
        ]);
    }

    public function testGetOneNews()
    {
        $news = News::factory()->create();
    
        $response = $this->get("api/news/{$news->id}");
    
        $response->assertStatus(200);
        $response->assertJsonIsObject();
    }

    public function testGetNews()
    {    
        News::factory()->create();
        $response = $this->get('api/news');
    
        $response->assertStatus(200);
        $response->assertJsonIsArray();
    }

    public function testDeleteNews()
    {
        $news = News::factory()->create();
        $token = ['token' =>$this->getTokenOfUser()];
    
        $response = $this->delete("api/news/{$news->id}", $token);
    
        $response->assertStatus(200);
        $response->assertSeeText([
            'Новость удалена'
        ]);
    }

    public function testUpdateNews()
    {
        $news = News::factory()->create();
        $data = [
            'title' => 'Updated Title',
            'content' => 'Updated Content',
            'token' => $this->getTokenOfUser()
        ];

        $response = $this->put("api/news/{$news->id}", $data);

        $response->assertStatus(200);
        $response->assertSeeText([
            'Новость изменена'
        ]);
    }


}
