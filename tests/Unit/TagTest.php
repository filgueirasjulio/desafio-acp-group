<?php

namespace Tests\Unit;

use App\Models\Tag;
use Tests\TestCase;
use App\Repositories\TagRepository;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TagTest extends TestCase
{
    use RefreshDatabase;

    private TagRepository $tagRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->tagRepository = new TagRepository(new Tag());
    }

    public function test_find_returns_tag_by_id()
    {
        $tag = Tag::factory()->create();

        $foundTag = $this->tagRepository->find($tag->id);

        $this->assertInstanceOf(Tag::class, $foundTag);
        $this->assertEquals($tag->id, $foundTag->id);
    }

    public function test_find_returns_null_for_non_existent_tag()
    {
        $tag = $this->tagRepository->find(999);  // ID que não existe

        $this->assertNull($tag);
    }

    public function test_store_creates_tag()
    {
        $tag = Tag::factory()->create([
            'description' => 'Test Tag Description',  
            'slug' => 'test-tag',
            'bg_color' => '#ffffff',
        ]);

        $this->assertInstanceOf(Tag::class, $tag);
        $this->assertDatabaseHas('tags', [
            'description' => 'Test Tag Description',
            'slug' => 'test-tag',
            'bg_color' => '#ffffff'
        ]);
    }

    public function test_update_updates_existing_tag()
    {
        $tag = Tag::factory()->create();

        $updatedData = [
            'description' => 'Updated Tag',
            'slug' => 'updated-tag',
            'bg_color' => '#000000',
        ];

        $this->tagRepository->update($tag->id, $updatedData);

        $this->assertDatabaseHas('tags', [
            'id' => $tag->id,
            'description' => 'Updated Tag',
            'slug' => 'updated-tag',
            'bg_color' => '#000000',
        ]);
    }

    public function test_update_throws_exception_for_non_existent_tag()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Tag not found.');

        $this->tagRepository->update(999, [
            'name' => 'Non-existent Tag',
            'slug' => 'non-existent-tag',
            'bg_color' => '#ff0000'
        ]);
    }

    public function test_destroy_deletes_tag()
    {
        $tag = Tag::factory()->create();

        $this->tagRepository->destroy($tag->id);

        $this->assertDatabaseMissing('tags', [
            'id' => $tag->id
        ]);
    }

    public function test_destroy_throws_exception_for_non_existent_tag()
    {
       $tag = Tag::factory()->create();

        $this->tagRepository->destroy($tag->id);

        $this->assertDatabaseMissing('tags', ['id' => $tag->id]);
    }
}
