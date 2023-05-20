<?php

namespace Tests\Unit\Controllers;

use App\Http\Controllers\HomeController;
use App\Models\Product;
use App\Models\Category;
use App\Models\Store;
use App\Models\Cart;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use Mockery;
use Tests\TestCase;

class HomeControllerTest extends TestCase
{
    public function testHome()
    {
        $request = Mockery::mock(Request::class);
        $request->shouldReceive('input')->with('query')->andReturn('search query');
        $request->shouldReceive('input')->with('sort', 'recent')->andReturn('recent');
        $request->shouldReceive('input')->with('tagName', null)->andReturn(null);
        $request->shouldReceive('input')->with('category')->andReturn(null);

        $storeUrl = 'store-url';
        $currentStoreName = 'Current Store';

        $sortOrder = 'desc';
        $sortBy = 'updated_at';

        $parentCategoryName = 'Parent Category';
        $childCategoryName = 'Child Category';

        $category = null;
        $products = Mockery::mock(Product::class);
        $products->shouldReceive('getOrderedProductList')->with($sortBy, $sortOrder)->andReturn([]);

        $mockCategory = Mockery::mock(Category::class);
        $mockCategory->shouldReceive('where')->with('type', 'P')->andReturnSelf();
        $mockCategory->shouldReceive('get')->andReturn([]);

        $mockManageStoreController = Mockery::mock('overload:App\Http\Controllers\ManageStoreController');
        $mockManageStoreController->shouldReceive('getCurrentUrl')->andReturn($storeUrl);

        $mockAuth = Mockery::mock('overload:Illuminate\Support\Facades\Auth');
        $mockAuth->shouldReceive('id')->andReturn(null);

        $mockRoute = Mockery::mock('overload:Illuminate\Support\Facades\Route');
        $mockRoute->shouldReceive('currentRouteName')->andReturn('pages.home');

        $mockStore = Mockery::mock(Store::class);
        $mockStore->shouldReceive('whereRaw')->withArgs(['lower(name) = ?', strtolower(str_replace('-', ' ', $storeUrl))])->andReturnSelf();
        $mockStore->shouldReceive('first')->andReturnNull();

        Log::shouldReceive('warning')->withArgs(['The sort variables have not been set correctly.']);

        $mockCache = Mockery::mock('overload:Illuminate\Support\Facades\Cache');
        $mockCache->shouldReceive('get')->andReturnNull();

        $mockView = Mockery::mock('overload:Illuminate\Support\Facades\View');
        $mockView->shouldReceive('make')->withArgs(['pages.home', Mockery::subset([
            'products' => [],
            'query' => 'search query',
            'category' => null,
            'parentCategory' => '',
            'parentCategoryName' => '',
            'childCategoryName' => '',
            'parentCategories' => [],
            'childCategories' => [],
            'sort' => 'recent',
            'tagName' => null,
            'currentStoreName' => null,
        ])]);

        $homeController = new HomeController();
        $homeController->home($request);
    }

    public function testGetMainImage()
    {
        $productId = 1;
        $cacheKey = 'product_main_image_' . $productId;
        $mainImage = 'path/to/main/image.jpg';

        $mockCache = Mockery::mock('overload:Illuminate\Support\Facades\Cache');
        $mockCache->shouldReceive('get')->with($cacheKey)->andReturnNull();
        $mockCache->shouldReceive('put')->withArgs([$cacheKey, $mainImage, 15768000]);

        $mockClient = Mockery::mock('overload:GuzzleHttp\Client');
        $mockClient->shouldReceive('get')->andReturnSelf();
        $mockClient->shouldReceive('getBody')->andReturnSelf();
        $mockClient->shouldReceive('json')->andReturn([
            'data' => [
                [
                    'path' => 'path/to/image1.jpg',
                    'main' => 0,
                ],
                [
                    'path' => $mainImage,
                    'main' => 1,
                ],
                [
                    'path' => 'path/to/image3.jpg',
                    'main' => 0,
                ],
            ]
        ]);

        $homeController = new HomeController();
        $result = $homeController->getMainImage($productId);

        $this->assertEquals($mainImage, $result);
    }

    public function testGetImages()
    {
        $productId = 1;
        $cacheKey = 'product_images_' . $productId;
        $images = [
            'path/to/image1.jpg',
            'path/to/image2.jpg',
            'path/to/image3.jpg',
        ];

        $mockCache = Mockery::mock('overload:Illuminate\Support\Facades\Cache');
        $mockCache->shouldReceive('get')->with($cacheKey)->andReturnNull();
        $mockCache->shouldReceive('put')->withArgs([$cacheKey, $images, 15768000]);

        $mockClient = Mockery::mock('overload:GuzzleHttp\Client');
        $mockClient->shouldReceive('get')->andReturnSelf();
        $mockClient->shouldReceive('getBody')->andReturnSelf();
        $mockClient->shouldReceive('json')->andReturn([
            'data' => [
                [
                    'path' => 'path/to/image1.jpg',
                    'main' => 0,
                ],
                [
                    'path' => 'path/to/image2.jpg',
                    'main' => 0,
                ],
                [
                    'path' => 'path/to/image3.jpg',
                    'main' => 0,
                ],
            ]
        ]);

        $homeController = new HomeController();
        $result = $homeController->getImages($productId);

        $this->assertEquals($images, $result);
    }

    public function testSetSortProducts()
    {
        $homeController = new HomeController();

        $result = $homeController->setSortProducts('recent', true);
        $this->assertEquals('desc', $result);

        $result = $homeController->setSortProducts('recent', false);
        $this->assertEquals('updated_at', $result);

        $result = $homeController->setSortProducts('nameAsc', true);
        $this->assertEquals('asc', $result);

        $result = $homeController->setSortProducts('nameAsc', false);
        $this->assertEquals('name', $result);

        $result = $homeController->setSortProducts('nameDesc', true);
        $this->assertEquals('desc', $result);

        $result = $homeController->setSortProducts('nameDesc', false);
        $this->assertEquals('name', $result);

        $result = $homeController->setSortProducts('priceAsc', true);
        $this->assertEquals('desc', $result);

        $result = $homeController->setSortProducts('priceAsc', false);
        $this->assertEquals('price', $result);

        $result = $homeController->setSortProducts('priceDesc', true);
        $this->assertEquals('asc', $result);

        $result = $homeController->setSortProducts('priceDesc', false);
        $this->assertEquals('price', $result);

        // Test invalid sort option
        $this->expectException(\Exception::class);
        $homeController->setSortProducts('invalid', true);
    }

    public function testShowProductDetails()
    {
        $productId = 1;
        $mockProduct = Mockery::mock('alias:App\Models\Product');
        $mockProduct->shouldReceive('findOrFail')->with($productId)->andReturnSelf();

        $mockCategory = Mockery::mock('alias:App\Models\Category');
        $mockCategory->shouldReceive('where')->with('product_id', $productId)->andReturnSelf();
        $mockCategory->shouldReceive('pluck')->with('name')->andReturn(['SubCategory']);
        $mockCategory->shouldReceive('where')->with('name', 'SubCategory')->andReturnSelf();
        $mockCategory->shouldReceive('value')->with('parent_id')->andReturn(1);
        $mockCategory->shouldReceive('where')->with('id', 1)->andReturnSelf();
        $mockCategory->shouldReceive('value')->with('name')->andReturn('Category');

        $mockStore = Mockery::mock('alias:App\Models\Store');
        $mockStore->shouldReceive('where')->with('id', $productId)->andReturnSelf();
        $mockStore->shouldReceive('value')->with('name')->andReturn('Store Name');

        $homeController = new HomeController();
        $result = $homeController->showProductDetails($productId);

        $this->assertIsObject($result);
    }

    public function testToggleProductFromCart()
    {
        $request = new Request();
        $request->merge(['0' => 'product_id']);

        $mockAuth = Mockery::mock('alias:Illuminate\Support\Facades\Auth');
        $mockAuth->shouldReceive('check')->andReturn(true);
        $mockAuth->shouldReceive('id')->andReturn(1);

        $mockCart = Mockery::mock('alias:App\Models\Cart');
        $mockCart->shouldReceive('where')->with('user_id', 1)->andReturnSelf();
        $mockCart->shouldReceive('first')->andReturnSelf();
        $mockCart->shouldReceive('products')->andReturnSelf();
        $mockCart->shouldReceive('toggle')->with('product_id')->andReturnNull();

        $homeController = new HomeController();
        $result = $homeController->toggleProductFromCart($request);

        $this->assertNull($result);
    }

    public function testGetProductsFromCart()
    {
        $request = new Request();

        $mockAuth = Mockery::mock('alias:Illuminate\Support\Facades\Auth');
        $mockAuth->shouldReceive('check')->andReturn(true);
        $mockAuth->shouldReceive('id')->andReturn(1);

        $mockCart = Mockery::mock('alias:App\Models\Cart');
        $mockCart->shouldReceive('getCartProducts')->andReturnSelf();
        $mockCart->shouldReceive('pluck')->with('id')->andReturn(['product_id']);

        $homeController = new HomeController();
        $result = $homeController->getProductsFromCart($request);

        $this->assertIsArray($result);
        $this->assertEquals(['product_id'], $result);
    }
}
