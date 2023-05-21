<?php

namespace Tests\Feature\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use App\Models\Store;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class OrderControllerTest extends TestCase
{
    public function testOrderMethodWhenUserIsNotLoggedIn()
    {
        $response = $this->get('/order');
        
        $response->assertStatus(Response::HTTP_FOUND);
        $response->assertRedirect('/login');
    }
}
