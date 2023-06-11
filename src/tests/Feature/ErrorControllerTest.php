<?php

namespace Tests\Feature\Controllers;

use Tests\TestCase;
use App\Models\Product;

class ErrorControllerTest extends TestCase
{
    /**
     * Test the productNotFound method of the ErrorController.
     *
     * @return void
     */
    public function testProductNotFound()
    {
        // Call the productNotFound method
        $response = $this->get(route('errors.productNotFound'));

        // Assert the response
        $response->assertViewIs('errors.productNotFound');
        $response->assertViewHas('products');
    }

    /**
     * Test the storeNotFound method of the ErrorController.
     *
     * @return void
     */
    public function testStoreNotFound()
    {
        // Call the storeNotFound method
        $response = $this->get(route('errors.storeNotFound'));

        // Assert the response
        $response->assertViewIs('errors.storeNotFound');
        $response->assertViewHas('products');
    }

    /**
     * Test the defaultError method of the ErrorController.
     *
     * @return void
     */
    public function testDefaultError()
    {
        // Call the defaultError method
        $response = $this->get(route('errors.defaultError'));

        // Assert the response
        $response->assertViewIs('errors.defaultError');
    }
}
