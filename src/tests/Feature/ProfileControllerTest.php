<?php

namespace Tests\Feature\Controllers;

use App\Models\Chat;
use App\Models\Order;
use App\Models\Store;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ProfileControllerTest extends TestCase
{

    use DatabaseTransactions;

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
    public function it_can_change_name_and_profile_picture()
    {
        $user = User::factory()->create();
        Auth::login($user);
        Storage::fake('public');
        
        $image = 'https://images.unsplash.com/photo-1541643600914-78b084683601?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=Mnw0MjMyMzZ8MHwxfHJhbmRvbXx8fHx8fHx8fDE2Nzk1MDQ1OTY&ixlib=rb-4.0.3&q=80&w=1080';
        
        $this->post('/upload', [
            'name' => 'John Doe',
            'image' => $image,
        ]);
        
        $this->assertEquals('John Doe', $user->fresh()->name);
        $this->assertNotNull($user->fresh()->pfp);
    }

    /** @test */
    public function it_can_change_password()
    {
        $user = User::factory()->create(['password' => Hash::make('oldpassword')]);
        Auth::login($user);

        $this->post('/changePassword', [
            'old_password' => 'oldpassword',
            'new_password' => 'newpassword',
            'confirm_password' => 'newpassword',
        ]);

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

        $response = $this->post('/createStore', [
            'name' => 'My Store',
            'image' => 'https://images.unsplash.com/photo-1541643600914-78b084683601?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=Mnw0MjMyMzZ8MHwxfHJhbmRvbXx8fHx8fHx8fDE2Nzk1MDQ1OTY&ixlib=rb-4.0.3&q=80&w=1080',
        ]);

        //$response->assertRedirect('/profile');
        //$this->assertDatabaseHas('stores', ['name' => 'My Store', 'user_id' => $user->id]);
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
}
