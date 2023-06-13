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
use Illuminate\Http\UploadedFile;

class ProfileControllerTest extends TestCase
{

    use DatabaseTransactions;

    /** @test */
    public function it_can_change_name()
    {
        $user = User::factory()->create();
        Auth::login($user);
        Storage::fake('public');

        $this->post('/upload', [
            'name' => 'John Doe'
        ]);

        $this->assertEquals('John Doe', $user->fresh()->name);
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
    public function test_it_can_check_user_has_store()
    {
        $user = User::factory()->create();

        $store = Store::create([
            'name' => 'Your Store Name',
            'logo' => 'your-logo-path.png',
            'user_id' => $user->id,
        ]);

        Auth::login($user);

        $this->assertTrue(Store::where('user_id', $user->id)->exists());
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
