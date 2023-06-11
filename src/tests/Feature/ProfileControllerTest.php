<?php

namespace Tests\Feature\Controllers;

use App\Models\Chat;
use App\Models\Order;
use App\Models\Store;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProfileControllerTest extends TestCase
{
    /** @test */
    public function it_can_check_specific_unread_chat()
    {
        $user = User::factory()->create();
        $order = Order::factory()->create();
        $chat1 = Chat::factory()->create(['order_id' => $order->id, 'read' => false, 'type' => 'B']);
        $chat2 = Chat::factory()->create(['order_id' => $order->id, 'read' => true, 'type' => 'S']);

        Auth::login($user);

        $response = $this->get('/check-specific-unread-chat/' . $order->id . '/buyer_id');

        $this->assertEquals(1, $response->getContent());
    }

    /** @test */
    public function it_can_get_order_history_for_buyer()
    {
        $user = User::factory()->create();
        $order1 = Order::factory()->create(['buyer_id' => $user->id, 'number' => '123']);
        $order2 = Order::factory()->create(['buyer_id' => $user->id, 'number' => '456']);
        $order3 = Order::factory()->create(['buyer_id' => $user->id, 'number' => '789']);
        $product1 = $order1->products()->save($this->createProduct());
        $product2 = $order2->products()->save($this->createProduct());
        $product3 = $order3->products()->save($this->createProduct());

        Auth::login($user);

        $response = $this->get('/get-order-history/buyer_id');

        $response->assertJson([
            '123' => [
                [
                    'product' => [
                        'id' => $product1->id,
                    ],
                    'accepted' => $order1->accepted,
                    'id' => $order1->id,
                ],
            ],
            '456' => [
                [
                    'product' => [
                        'id' => $product2->id,
                    ],
                    'accepted' => $order2->accepted,
                    'id' => $order2->id,
                ],
            ],
            '789' => [
                [
                    'product' => [
                        'id' => $product3->id,
                    ],
                    'accepted' => $order3->accepted,
                    'id' => $order3->id,
                ],
            ],
        ]);
    }

    /** @test */
    public function it_can_get_order_history_for_seller()
    {
        $user = User::factory()->create();
        $order1 = Order::factory()->create(['seller_id' => $user->id, 'number' => '123']);
        $order2 = Order::factory()->create(['seller_id' => $user->id, 'number' => '456']);
        $order3 = Order::factory()->create(['seller_id' => $user->id, 'number' => '789']);
        $product1 = $order1->products()->save($this->createProduct());
        $product2 = $order2->products()->save($this->createProduct());
        $product3 = $order3->products()->save($this->createProduct());

        Auth::login($user);

        $response = $this->get('/get-order-history/seller_id');

        $response->assertJson([
            '123' => [
                [
                    'product' => [
                        'id' => $product1->id,
                    ],
                    'accepted' => $order1->accepted,
                    'id' => $order1->id,
                ],
            ],
            '456' => [
                [
                    'product' => [
                        'id' => $product2->id,
                    ],
                    'accepted' => $order2->accepted,
                    'id' => $order2->id,
                ],
            ],
            '789' => [
                [
                    'product' => [
                        'id' => $product3->id,
                    ],
                    'accepted' => $order3->accepted,
                    'id' => $order3->id,
                ],
            ],
        ]);
    }

    /** @test */
    public function it_can_accept_order()
    {
        $user = User::factory()->create();
        $order = Order::factory()->create(['seller_id' => $user->id]);
        $this->mock(ChatController::class, function ($mock) {
            $mock->shouldReceive('createMessage')->once();
        });

        Auth::login($user);

        $response = $this->post('/accept-order/' . $order->id);

        $response->assertRedirect('/profile');
        $this->assertTrue($order->fresh()->accepted);
    }

    /** @test */
    public function it_can_deny_order()
    {
        $user = User::factory()->create();
        $order = Order::factory()->create(['seller_id' => $user->id]);
        $product = $order->products()->save($this->createProduct());
        $this->mock(ChatController::class, function ($mock) {
            $mock->shouldReceive('createMessage')->once();
        });

        Auth::login($user);

        $response = $this->post('/deny-order/' . $order->id);

        $response->assertRedirect('/profile');
        $this->assertDatabaseMissing('orders', ['id' => $order->id]);
        $this->assertDatabaseHas('products', ['id' => $product->id, 'sold' => false, 'enabled' => true]);
    }

    /** @test */
    public function it_can_change_password()
    {
        $user = User::factory()->create(['password' => Hash::make('oldpassword')]);
        Auth::login($user);

        $response = $this->post('/change-password', [
            'old_password' => 'oldpassword',
            'new_password' => 'newpassword',
            'confirm_password' => 'newpassword',
        ]);

        $response->assertRedirect('/profile');
        $this->assertTrue(Hash::check('newpassword', $user->fresh()->password));
    }

    /** @test */
    public function it_can_check_user_has_store()
    {
        $user = User::factory()->create();
        $store = Store::factory()->create(['user_id' => $user->id]);

        Auth::login($user);

        $response = $this->get('/check-user-has-store/' . $user->id);

        $response->assertExactJson(['exists' => true]);
    }

    /** @test */
    public function it_can_create_store()
    {
        $user = User::factory()->create();
        Auth::login($user);

        Storage::fake('public');

        $response = $this->post('/create-store', [
            'name' => 'My Store',
            'image' => $this->createImageFile(),
        ]);

        $response->assertRedirect('/profile');
        $this->assertDatabaseHas('stores', ['name' => 'My Store', 'user_id' => $user->id]);
    }

    /** @test */
    public function it_can_upload_profile()
    {
        $user = User::factory()->create();
        Auth::login($user);

        Storage::fake('public');

        $response = $this->post('/upload', [
            'name' => 'John Doe',
            'image' => $this->createImageFile(),
        ]);

        $response->assertRedirect()->back();
        $this->assertEquals('John Doe', $user->fresh()->name);
        $this->assertNotNull($user->fresh()->pfp);
    }

    /**
     * Create a product for testing.
     *
     * @return \App\Models\Product
     */
    private function createProduct()
    {
        return Product::factory()->create();
    }

    /**
     * Create a sample image file for testing.
     *
     * @return \Illuminate\Http\Testing\File
     */
    private function createImageFile()
    {
        return UploadedFile::fake()->image('test.jpg');
    }
}
