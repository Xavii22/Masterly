<?php

namespace Tests\Unit\Controllers;

use App\Http\Controllers\CreateProductController;
use App\Models\Category;
use App\Models\Product;
use App\Models\Store;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mockery;
use Tests\TestCase;

class CreateProductControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testCreator()
    {
        $categoryMock = Mockery::mock(Category::class);
        $categoryMock->shouldReceive('where')->with('type', 'C')->once()->andReturnSelf();
        $categoryMock->shouldReceive('get')->once()->andReturn(['subcategory1', 'subcategory2']);
        $this->app->instance(Category::class, $categoryMock);

        $createProductController = new CreateProductController();
        $response = $createProductController->creator();

        $this->assertEquals('pages.createProduct', $response->name()); // Check returned view name
        $this->assertEquals(['subcategory1', 'subcategory2'], $response->getData()['subcategories']); // Check returned subcategories
    }

    public function testCreateProduct()
    {
        Auth::shouldReceive('id')->once()->andReturn(1);

        $request = new Request([
            'name' => 'Test Product',
            'description' => 'Test description',
            'price' => 10.99,
            'image' => 'test.jpg',
        ]);

        $storeMock = Mockery::mock(Store::class);
        $storeMock->shouldReceive('where')->with('user_id', 1)->once()->andReturnSelf();
        $storeMock->shouldReceive('value')->with('id')->once()->andReturn(1);
        $this->app->instance(Store::class, $storeMock);

        $productMock = Mockery::mock(Product::class);
        $productMock->shouldReceive('create')->with([
            'name' => 'Test Product',
            'description' => 'Test description',
            'price' => 10.99,
            'image' => 'test.jpg',
            'store_id' => 1,
        ])->once();
        $this->app->instance(Product::class, $productMock);

        $createProductController = new CreateProductController();
        $response = $createProductController->createProduct($request);

        $this->assertEquals('pages.manageStore', $response->name()); // Check returned view name
    }

    // Additional test cases can be added for edge cases, validation, etc.
}
