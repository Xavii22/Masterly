<?php

namespace Tests\Feature\Controllers;

use Tests\TestCase;
use App\Models\Order;
use App\Models\Chat;
use App\Models\User;
use App\Http\Controllers\HeaderController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class HeaderControllerTest extends TestCase
{

    use DatabaseTransactions;

    /**
     * Test the header method of the HeaderController.
     *
     * @return void
     */
    public function testHeader()
    {
        // Authenticate the user
        $user = User::factory()->create();
        Auth::login($user);

        $product = User::factory()->create();
        // Call the header method
        $response = $this->get(route('pages.product', [$product->id]));

        // Assert the response
        $response->assertViewIs('pages.product');
    }
}
