<?php

namespace Tests\Unit\Controllers;

use App\Http\Controllers\LoginController;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Tests\TestCase;

class LoginControllerTest extends TestCase
{
    // public function testShowLoginForm()
    // {
    //     $loginController = new LoginController();
    //     $result = $loginController->showLoginForm();

    //     $this->assertInstanceOf(View::class, $result);
    //     $this->assertEquals('pages.login', $result->name());
    // }

    // public function testLoginWithValidCredentials()
    // {
    //     $request = new Request([
    //         'email' => 'test@example.com',
    //         'password' => 'password',
    //     ]);

    //     $mockAuth = $this->mock(Auth::class);
    //     $mockAuth->shouldReceive('attempt')->once()->with([
    //         'email' => 'test@example.com',
    //         'password' => 'password',
    //     ])->andReturn(true);

    //     $mockSession = $this->mock('overload:Illuminate\Session\Store');
    //     $mockSession->shouldReceive('regenerate')->once();

    //     $mockRedirectResponse = $this->mock(RedirectResponse::class);
    //     $mockRedirectResponse->shouldReceive('intended')->once()->with(route('pages.home'))->andReturn('redirect response');

    //     $loginController = new LoginController();
    //     $result = $loginController->login($request);

    //     $this->assertEquals('redirect response', $result);
    // }

    // public function testLoginWithInvalidCredentials()
    // {
    //     $request = new Request([
    //         'email' => 'test@example.com',
    //         'password' => 'password',
    //     ]);

    //     $mockAuth = $this->mock(Auth::class);
    //     $mockAuth->shouldReceive('attempt')->once()->with([
    //         'email' => 'test@example.com',
    //         'password' => 'password',
    //     ])->andReturn(false);

    //     $mockSession = $this->mock('overload:Illuminate\Session\Store');
    //     $mockSession->shouldReceive('flash')->once()->with('status', 'Incorrect username or password!');

    //     $mockRedirectResponse = $this->mock(RedirectResponse::class);
    //     $mockRedirectResponse->shouldReceive('route')->once()->with('pages.login')->andReturn('redirect response');

    //     $loginController = new LoginController();
    //     $result = $loginController->login($request);

    //     $this->assertEquals('redirect response', $result);
    // }

    // public function testLogout()
    // {
    //     $mockSession = $this->mock('overload:Illuminate\Session\Store');
    //     $mockSession->shouldReceive('flush')->once();

    //     $mockAuth = $this->mock(Auth::class);
    //     $mockAuth->shouldReceive('logout')->once();

    //     $mockRedirectResponse = $this->mock(RedirectResponse::class);
    //     $mockRedirectResponse->shouldReceive('route')->once()->with('pages.landing')->andReturn('redirect response');

    //     $loginController = new LoginController();
    //     $result = $loginController->logout();

    //     $this->assertEquals('redirect response', $result);
    // }
}
