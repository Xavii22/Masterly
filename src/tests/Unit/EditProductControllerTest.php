<?php

namespace Tests\Unit\Controllers;

use App\Http\Controllers\EditProductController;
use App\Models\Category;
use App\Models\Product;
use GuzzleHttp\Client;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Mockery;
use Tests\TestCase;

class EditProductControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testEditProduct()
    {
        $categoryMock = Mockery::mock(Category::class);
        $categoryMock->shouldReceive('getActiveCategoriesOfProduct')->with('C', 1)->once()->andReturn(['subcategory1', 'subcategory2']);
        $this->app->instance(Category::class, $categoryMock);

        $productMock = Mockery::mock(Product::class);
        $productMock->shouldReceive('where')->with('id', 1)->once()->andReturnSelf();
        $productMock->shouldReceive('first')->once()->andReturn('product1');
        $this->app->instance(Product::class, $productMock);

        $editProductController = new EditProductController();
        $response = $editProductController->editProduct(1);

        $this->assertEquals('pages.editProduct', $response->name()); // Check returned view name
        $this->assertEquals('product1', $response->getData()['product']); // Check returned product
        $this->assertEquals(1, $response->getData()['productId']); // Check returned product ID
        $this->assertEquals(['subcategory1', 'subcategory2'], $response->getData()['subcategories']); // Check returned subcategories
    }

    public function testEditProductDetails()
    {
        $request = new Request([
            'name' => 'Updated Product',
            'description' => 'Updated description',
            'price' => 19.99,
        ]);

        $productMock = Mockery::mock(Product::class);
        $productMock->shouldReceive('where')->with('id', 1)->once()->andReturnSelf();
        $productMock->shouldReceive('first')->once()->andReturn($productMock);
        $productMock->shouldReceive('save')->once();
        $this->app->instance(Product::class, $productMock);

        $editProductController = new EditProductController();
        $response = $editProductController->editProductDetails($request);

        $this->assertEquals('pages.manageStore', $response->name()); // Check returned view name
    }

    public function testEditProductSubcategory()
    {
        $request = new Request([
            'id' => 1,
            'subcategory' => 'New Subcategory',
        ]);

        $productMock = Mockery::mock(Product::class);
        $productMock->shouldReceive('find')->with(1)->once()->andReturnSelf();
        $productMock->categories = Mockery::mock();
        $productMock->categories->shouldReceive('updateExistingPivot')->once();
        $this->app->instance(Product::class, $productMock);

        $categoryMock = Mockery::mock(Category::class);
        $categoryMock->shouldReceive('getCategoryOfProduct')->with(1)->once()->andReturn(1);
        $categoryMock->shouldReceive('where')->with('name', 'New Subcategory')->once()->andReturnSelf();
        $categoryMock->shouldReceive('value')->with('id')->once()->andReturn(2);
        $this->app->instance(Category::class, $categoryMock);

        $editProductController = new EditProductController();
        $response = $editProductController->editProductSubcategory($request);

        $this->assertEquals('pages.landing', $response->name()); // Check returned view name
    }

    public function testEditProductState()
    {
        $request = new Request([
            'id' => 1,
            'important' => 'on',
            'enabled' => 'on',
        ]);

        $productMock = Mockery::mock(Product::class);
        $productMock->shouldReceive('find')->with(1)->once()->andReturnSelf();
        $productMock->shouldReceive('save')->once();
        $this->app->instance(Product::class, $productMock);

        $editProductController = new EditProductController();
        $response = $editProductController->editProductState($request);

        $this->assertEquals('pages.manageStore', $response->name()); // Check returned view name
    }

    public function testDeleteProduct()
    {
        $request = new Request([
            'id' => 1,
        ]);

        $productMock = Mockery::mock(Product::class);
        $productMock->shouldReceive('find')->with(1)->once()->andReturnSelf();
        $productMock->shouldReceive('delete')->once();
        $this->app->instance(Product::class, $productMock);

        $editProductController = new EditProductController();
        $editProductController->deleteProduct($request);

        // Assert no exceptions are thrown
        $this->assertTrue(true);
    }

    public function testImageManager()
    {
        $clientMock = Mockery::mock(Client::class);
        $clientMock->shouldReceive('get')->with('http://localhost:8080/api/test-endpoint')->once()->andReturnSelf();
        $clientMock->shouldReceive('getBody')->once()->andReturn(json_encode(['image1', 'image2']));
        $this->app->instance(Client::class, $clientMock);

        $requestMock = Mockery::mock(Request::class);
        $requestMock->shouldReceive('route')->with('id')->once()->andReturn('test-endpoint');
        $this->app->instance(Request::class, $requestMock);

        $editProductController = new EditProductController();
        $response = $editProductController->imageManager($requestMock);

        $this->assertEquals(['image1', 'image2'], $response); // Check returned images
    }

    // Additional test cases can be added for edge cases, validation, etc.
}
