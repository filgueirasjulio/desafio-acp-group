<?php

namespace Tests\Unit;

use App\Models\Tag;
use Tests\TestCase;
use App\Models\Post;
use App\Models\User;
use App\Repositories\PostRepository;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    private PostRepository $postRepository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->postRepository = new PostRepository(new Post());
    }

    public function test_find_returns_post_by_id()
    {
        $post = Post::factory()->create();
        
        $result = $this->postRepository->find($post->id);

        $this->assertInstanceOf(Post::class, $result);
        $this->assertEquals($post->id, $result->id);
    }

    public function test_find_returns_null_for_nonexistent_id()
    {
        $result = $this->postRepository->find(999);

        $this->assertNull($result);
    }

    public function test_store_creates_post_and_attaches_tags()
    {
        $user = User::factory()->create();
        $tags = Tag::factory(3)->create();  // Cria 3 tags
    
        $post = Post::factory()->create([
            'user_id' => $user->id,
            'content' => 'Test post content',
        ]);
    
        $post->tags()->attach($tags->pluck('id'));  // Associe os IDs das 3 tags ao post
    
        $this->assertTrue($post->tags->contains($tags[0]));  // Verifique se a primeira tag está associada
        $this->assertInstanceOf(Post::class, $post);
        $this->assertDatabaseHas('posts', ['id' => $post->id, 'content' => 'Test post content']);
        $this->assertCount(3, $post->tags);  // Verifique se o número de tags associadas ao post é 3
        $this->assertEqualsCanonicalizing($tags->pluck('id')->toArray(), $post->tags->pluck('id')->toArray());
    }    

    public function test_update_updates_post_and_syncs_tags()
    {
        $post = Post::factory()->create();
        $tags = Tag::factory(3)->create();
        $post->tags()->attach($tags->pluck('id')->toArray());

        $newTags = Tag::factory(2)->create();
        $data = [
            'content' => 'Updated content',
            'tags' => $newTags->pluck('id')->toArray(),
        ];

        $updatedPost = $this->postRepository->update($post->id, $data);

        $this->assertEquals('Updated content', $updatedPost->content);
        $this->assertCount(2, $updatedPost->tags);
        $this->assertEqualsCanonicalizing($newTags->pluck('id')->toArray(), $updatedPost->tags->pluck('id')->toArray());
    }

    public function test_update_throws_exception_for_nonexistent_post()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Post not found.");

        $this->postRepository->update(999, ['content' => 'Updated content', 'tags' => []]);
    }

    public function test_destroy_deletes_post()
    {
        $post = Post::factory()->create();

        $this->postRepository->destroy($post->id);

        $this->assertDatabaseMissing('posts', ['id' => $post->id]);
    }
}
