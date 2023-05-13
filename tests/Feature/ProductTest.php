<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProductTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_can_create_product(): void
    {

        Storage::fake('public');
        $file = UploadedFile::fake()->image('product.jpg');

        $response = $this->post('http://localhost:8000/api/products', [
            'image' => $file,
            'name' => 'Test Product',
            'description' => 'Test Description',
            'price' => 100,
        ]);

        $this->assertDatabaseHas('products', [
            'name' => 'Test Product',
            'description' => 'Test Description',
            'price' => 100,
            'image_name' => $file->hashName(),
        ]);

        $response->assertStatus(200);
        Storage::disk('public')->assertExists('/assets/products/' . $file->hashName());
    }

    public function test_can_show_product()
    {
        $product = Product::latest()->first();
        $response = $this->get('http://localhost:8000/api/products/' . $product->id);

        $response
            ->assertStatus(200)
            ->assertSee($product->name);
    }

    public function test_can_update_product()
    {
        Storage::fake('public');
        $file = UploadedFile::fake()->image('product.jpg');
        $product = Product::latest()->first();

        $response = $this->post('http://localhost:8000/api/products/' . $product->id, [
            'name' => 'Test Product 2',
            'description' => 'Test Description 2',
            'price' => 200,
            'image' => $file,
        ]);

        $this->assertDatabaseHas('products', [
            'name' => 'Test Product 2',
            'description' => 'Test Description 2',
            'price' => 200,
            'image_name' => $file->hashName(),
        ]);

        $response->assertStatus(200);
        Storage::disk('public')->assertExists('/assets/products/' . $file->hashName());
    }

    public function test_can_search_product()
    {
        $response = $this->post('http://localhost:8000/api/search', [
            'query' => 'Test Product 2',
        ]);

        $response->assertStatus(200);
    }

    public function test_can_delete_product()
    {
        $product = Product::latest()->first();
        $response = $this->delete('http://localhost:8000/api/products/' . $product->name);

        $this->assertDatabaseMissing('products', [
            'id' => $product->id,
        ]);

        $response->assertStatus(200);
    }

    public function test_can_download_products()
    {
        $response = $this->get('http://localhost:8000/api/products-export');

        $response->assertStatus(200);
    }
}
