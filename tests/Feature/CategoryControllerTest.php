<?php

use App\Models\Category;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\Response;
use Tests\TestCase;

class CategoryControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function test_can_list_categories()
    {
        Category::factory()->count(10)->create();

        $response = $this->get('/api/categories');

        $response->assertStatus(Response::HTTP_OK);

        $response->assertJsonCount(10, 'data');
    }

    public function test_can_show_category()
    {
        $category = Category::factory()->create();

        $response = $this->get("/api/categories/{$category->id}");

        $response->assertStatus(Response::HTTP_OK);

        $response->assertJson([
            'data' => [
                'id' => $category->id,
            ]
        ]);
    }

    public function test_can_create_category()
    {
        $categoryData = [
            'name' => 'Test Category',
        ];

        $response = $this->post('/api/categories', $categoryData);

        $response->assertStatus(Response::HTTP_CREATED);

        $response->assertJson([
            'data' => [
                'name' => 'Test Category',
            ]
        ]);
    }

    public function test_can_update_category()
    {
        $category = Category::factory()->create();

        $updatedCategoryData = [
            'name' => 'Updated Category Name',
        ];

        $response = $this->put("/api/categories/{$category->id}", $updatedCategoryData);

        $response->assertStatus(Response::HTTP_OK);

        $response->assertJson([
            'data' => [
                'name' => 'Updated Category Name',
            ]
        ]);
    }

    public function test_can_delete_category()
    {
        $category = Category::factory()->create();

        $response = $this->delete("/api/categories/{$category->id}");

        $response->assertStatus(Response::HTTP_NO_CONTENT);

        $this->assertDatabaseMissing('categories', ['id' => $category->id]);
    }
}


