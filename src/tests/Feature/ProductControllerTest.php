<?php

namespace Tests\Feature\Controllers;

use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    /**
     * Test the product method of the ProductController.
     *
     * @return void
     */
    public function test_product()
    {
        // Send a GET request to the product endpoint if a product with id 1 is created.
        $response = $this->get('/product/1');

        // Assert that the response view matches the expected view
        $response->assertViewIs('pages.product');
    }
}
