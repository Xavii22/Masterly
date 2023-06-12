<?php

namespace Tests\Feature\Controllers;

use App\Models\Category;
use App\Http\Controllers\LandingController;
use App\Models\Product;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class LandingControllerTest extends TestCase
{

    /**
     * Test the landing method of the LandingController.
     *
     * @return void
     */
    public function test_landing()
    {
        // Mock the getActiveTagList method to return a sample array
        $this->mock(LandingController::class)
            ->shouldReceive('getActiveTagList')
            ->once()
            ->andReturn([
                ['id' => 1],
                ['id' => 2],
            ]);

        // Mock the getTagValues method to return a sample array
        $this->mock(LandingController::class)
            ->shouldReceive('getTagValues')
            ->once()
            ->andReturn([
                [
                    'id' => 1,
                    'name' => 'Category 1',
                    'products' => [],
                ],
                [
                    'id' => 2,
                    'name' => 'Category 2',
                    'products' => [],
                ],
            ]);

        // Mock the view method to assert that the correct view is returned
        $this->mock(LandingController::class)
            ->shouldReceive('view')
            ->with('pages.landing', [
                'tags' => [
                    [
                        'id' => 1,
                        'name' => 'Category 1',
                        'products' => [],
                    ],
                    [
                        'id' => 2,
                        'name' => 'Category 2',
                        'products' => [],
                    ],
                ],
            ])
            ->once();

        // Send a GET request to the landing endpoint
        $response = $this->get('/');

        $response->assertOk();
    }

    /**
     * Test the getActiveTagList method of the LandingController.
     *
     * @return void
     */
    public function test_getActiveTagList()
    {
        // Set the contents of the active tags file
        $activeTags = [
            'activeTags' => [
                ['id' => 1],
                ['id' => 2],
            ],
        ];
        file_put_contents(base_path() . env('ACTIVE_TAGS'), json_encode($activeTags));

        // Call the getActiveTagList method
        $controller = new LandingController();
        $result = $controller->getActiveTagList();

        // Assert that the result matches the expected active tags
        $this->assertEquals($activeTags['activeTags'], $result);
    }

    /**
     * Test the getTagValues method of the LandingController.
     *
     * @return void
     */
    public function test_getTagValues()
    {
        // Create sample categories and products
        $category1 = Category::factory()->create(['type' => 'T']);
        $category2 = Category::factory()->create(['type' => 'T']);

        $product1 = Product::factory()->create();
        $product2 = Product::factory()->create();

        $product1->categories()->attach($category1->id);
        $product2->categories()->attach($category2->id);

        // Call the getTagValues method
        $controller = new LandingController();
        $result = $controller->getTagValues();

        // Assert that the result matches the expected tag values
        $this->assertEquals([
            [
                'id' => $category1->id,
                'name' => $category1->name,
                'products' => [
                    $product1,
                ],
            ],
            [
                'id' => $category2->id,
                'name' => $category2->name,
                'products' => [
                    $product2,
                ],
            ],
        ], $result);
    }
}
