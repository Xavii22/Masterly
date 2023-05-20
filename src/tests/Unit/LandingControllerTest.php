<?php

namespace Tests\Unit\Controllers;

use App\Http\Controllers\LandingController;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Mockery;
use Tests\TestCase;

class LandingControllerTest extends TestCase
{
    public function testGetActiveTagList()
    {
        $fileContents = '{"activeTags": [{"id": 1}, {"id": 2}]}';

        // Mocking the file_get_contents function
        $mockFile = Mockery::mock('overload:file_get_contents');
        $mockFile->shouldReceive('file_get_contents')->with(base_path() . env('ACTIVE_TAGS'))->andReturn($fileContents);

        $landingController = new LandingController();
        $result = $landingController->getActiveTagList();

        $this->assertIsArray($result);
        $this->assertCount(2, $result);
        $this->assertEquals(1, $result[0]['id']);
        $this->assertEquals(2, $result[1]['id']);
    }

    public function testGetActiveTagListFileNotFound()
    {
        // Mocking the Log facade
        $mockLog = Mockery::mock('overload:Illuminate\Support\Facades\Log');
        $mockLog->shouldReceive('error')->with('File not found');

        $landingController = new LandingController();
        $result = $landingController->getActiveTagList();

        $this->assertNull($result);
    }

    public function testGetTagValues()
    {
        $activeTags = [
            ['id' => 1],
            ['id' => 2],
        ];

        $mockController = Mockery::mock('App\Http\Controllers\LandingController')->makePartial();
        $mockController->shouldReceive('getActiveTagList')->andReturn($activeTags);

        $mockCategory = Mockery::mock('alias:App\Models\Category');
        $mockCategory->shouldReceive('where')->andReturnSelf();
        $mockCategory->shouldReceive('value')->andReturn('Category Name');

        $mockProduct = Mockery::mock('alias:App\Models\Product');
        $mockProduct->shouldReceive('whereHas')->andReturnSelf();
        $mockProduct->shouldReceive('get')->andReturn(collect(['product1', 'product2']));

        $landingController = new LandingController();
        $result = $landingController->getTagValues();

        $this->assertIsArray($result);
        $this->assertCount(2, $result);
        $this->assertEquals(1, $result[0]['id']);
        $this->assertEquals('Category Name', $result[0]['name']);
        $this->assertEquals(['product1', 'product2'], $result[0]['products']->toArray());
        $this->assertEquals(2, $result[1]['id']);
        $this->assertEquals('Category Name', $result[1]['name']);
        $this->assertEquals(['product1', 'product2'], $result[1]['products']->toArray());
    }

    public function testGetTagValuesNoTagProductsFound()
    {
        $activeTags = [];

        $mockController = Mockery::mock('App\Http\Controllers\LandingController')->makePartial();
        $mockController->shouldReceive('getActiveTagList')->andReturn($activeTags);

        // Mocking the Log facade
        $mockLog = Mockery::mock('overload:Illuminate\Support\Facades\Log');
        $mockLog->shouldReceive('error')->with('No tag products found.');

        $landingController = new LandingController();
        $result = $landingController->getTagValues();

        $this->assertIsArray($result);
        $this->assertCount(0, $result);
    }

    public function testLanding()
    {
        $tags = [
            [
                'id' => 1,
                'name' => 'Category Name',
                'products' => ['product1', 'product2'],
            ],
        ];

        $mockController = Mockery::mock('App\Http\Controllers\LandingController')->makePartial();
        $mockController->shouldReceive('getTagValues')->andReturn($tags);

        $mockView = Mockery::mock('alias:Illuminate\View\View');
        $mockView->shouldReceive('make')->with('pages.landing', compact('tags'))->andReturn('rendered view');

        $landingController = new LandingController();
        $result = $landingController->landing();

        $this->assertInstanceOf(View::class, $result);
        $this->assertEquals('rendered view', $result);
    }
}
