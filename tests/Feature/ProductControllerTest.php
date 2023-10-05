<?php


use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Product;
use App\Models\Option;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_get_paginated_list_of_products()
    {
        Product::factory(10)->create();

        $response = $this->get('/api/products');

        $response->assertStatus(200);

        $response->assertJsonStructure(['products']);
    }

    public function test_can_create_a_product()
    {
        $productData = [
            'name' => 'Test Product',
            'category_id' => 1,
            'description' => 'This is a test product.',
            'price' => 19.99,
            'status' => 'active',
        ];

        $response = $this->post('/api/products', $productData);

        $response->assertStatus(201);

        $response->assertJsonStructure(['product']);

        $response->assertJson([
            'product' => $productData
        ]);
    }

    public function test_can_add_options_to_a_product()
    {
        $product = Product::factory()->create();

        $optionsData = [
            [
                'name' => 'Option 1',
                'price' => 5.99,
            ],
            [
                'name' => 'Option 2',
                'price' => 7.99,
            ],
        ];

        $response = $this->post("/api/products/{$product->id}/options", ['options' => $optionsData]);

        $response->assertStatus(201);

        $this->assertCount(2, $product->options);
    }

    public function test_can_show_a_product()
    {
        $product = Product::factory()->create();

        $response = $this->get("/api/products/{$product->id}");

        $response->assertStatus(200);

        $response->assertJsonStructure(['product']);
    }

    public function test_can_update_a_product()
    {
        $product = Product::factory()->create();

        $updatedData = [
            'name' => 'Updated Product Name',
            'price' => 29.99,
        ];

        $response = $this->put("/api/products/{$product->id}", $updatedData);

        $response->assertStatus(200);

        $this->assertDatabaseHas('products', $updatedData);
    }

    public function test_can_delete_a_product()
    {
        $product = Product::factory()->create();

        $response = $this->delete("/api/products/{$product->id}");

        $response->assertStatus(200);

        $this->assertDeleted($product);
    }
}

