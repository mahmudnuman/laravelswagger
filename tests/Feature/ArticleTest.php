<?php 


namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use App\Models\Article;
use App\Models\User;

class ArticleTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_retrieve_articles()
    {
        $user = User::factory()->create();

        Article::factory(3)->create();

        $response = $this->actingAs($user)
            ->getJson('/api/articles');

        $response->assertStatus(200)
            ->assertJsonCount(3); // Assuming you created 3 articles
    }

    /** @test */
    public function user_can_create_article()
    {
        $user = User::factory()->create([
            'password' => Hash::make('password'),
        ]);

        $articleData = [
            'title' => 'Test Article',
            'description' => 'This is a test article.',
        ];

        $response = $this->actingAs($user)
            ->postJson('/api/articles', $articleData);

        $response->assertStatus(201)
            ->assertJsonFragment($articleData);
    }

    /** @test */
    public function user_can_update_article()
    {
        $user = User::factory()->create([
            'password' => Hash::make('password'),
        ]);

        $article = Article::factory()->create();

        $updatedData = [
            'title' => 'Updated Title',
            'description' => 'Updated description.',
        ];

        $response = $this->actingAs($user)
            ->putJson("/api/articles/{$article->id}", $updatedData);

        $response->assertStatus(200)
            ->assertJsonFragment($updatedData);
    }

    /** @test */
    public function user_can_delete_article()
    {
        $user = User::factory()->create([
            'password' => Hash::make('password'),
        ]);

        $article = Article::factory()->create();

        $response = $this->actingAs($user)
            ->deleteJson("/api/articles/{$article->id}");

        $response->assertStatus(204);

        $this->assertDatabaseMissing('articles', ['id' => $article->id]);
    }
}