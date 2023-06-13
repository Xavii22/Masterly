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
     * Test the getActiveTagList method of the LandingController.
     *
     * @return void
     */
    public function test_getActiveTagList()
    {
        // Set the contents of the active tags file
        $activeTags = [
            "activeTags" => [
                [
                    "id" => 12,
                    "amount" => 4
                ],
                [
                    "id" => 13,
                    "amount" => 3
                ],
                [
                    "id" => 14,
                    "amount" => 20
                ]
            ]
        ];
        file_put_contents(base_path() . env('ACTIVE_TAGS'), json_encode($activeTags));

        // Call the getActiveTagList method
        $controller = new LandingController();
        $result = $controller->getActiveTagList();

        // Assert that the result matches the expected active tags
        $this->assertEquals($activeTags['activeTags'], $result);
    }
}
