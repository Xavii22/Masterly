<?php

namespace Tests\Feature\Controllers;

use Tests\TestCase;
use App\Models\Product;
use App\Models\Cart;
use App\Models\User;

class CartControllerTest extends TestCase
{
    public function testCartView()
    {
        $response = $this->get('/cart');
        
        $response->assertStatus(200);
        $response->assertViewIs('pages.cart');
    }
}
