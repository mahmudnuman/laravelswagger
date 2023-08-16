<?php 


use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class ArticleTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function logged_in_user_can_create_article()
    {
        $user = User::factory()->create();
        $articleData = [
            'title' => 'New Article Title',
            'description' => 'New Article Description',
        ];

        $response = $this->actingAs($user)
            ->postJson('/api/articles', $articleData);

        $response->assertStatus(201)
            ->assertJsonFragment($articleData);

        $this->assertDatabaseHas('articles', $articleData);
    }
}