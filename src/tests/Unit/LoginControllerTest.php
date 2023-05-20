<?php

namespace Tests\Unit\Controllers;

use App\Http\Controllers\LoginController;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Mockery;
use Tests\TestCase;


class LoginControllerTest extends TestCase
{
    public function testShowLoginForm()
    {
        $mockView = Mockery::mock('alias:Illuminate\View\View');
        $mockView->shouldReceive('make')->with('pages.login')->andReturn('rendered view');

        $loginController = new LoginController();
        $result = $loginController->showLoginForm();

        $this->assertInstanceOf(View::class, $result);
        $this->assertEquals('rendered view', $result);
    }

    public function testLoginWithValidCredentials()
    {
        $request = Mockery::mock(Request::class);
        $request->shouldReceive('validate')->once()->with([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);
        $request->shouldReceive('only')->once()->with('email', 'password')->andReturn(['email' => 'test@example.com', 'password' => 'password']);

        $mockAuth = Mockery::mock('overload:Illuminate\Support\Facades\Auth');
        $mockAuth->shouldReceive('attempt')->once()->with(['email' => 'test@example.com', 'password' => 'password'])->andReturn(true);

        $mockSession = Mockery::mock('overload:Illuminate\Session\Store');
        $mockSession->shouldReceive('regenerate')->once();

        $mockRedirectResponse = Mockery::mock(RedirectResponse::class);
        $mockRedirectResponse->shouldReceive('intended')->once()->with(route('pages.home'))->andReturn('redirect response');

        $loginController = new LoginController();
        $result = $loginController->login($request);

        $this->assertEquals('redirect response', $result);
    }

    public function testLoginWithInvalidCredentials()
    {
        $request = Mockery::mock(Request::class);
        $request->shouldReceive('validate')->once()->with([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);
        $request->shouldReceive('only')->once()->with('email', 'password')->andReturn(['email' => 'test@example.com', 'password' => 'password']);

        $mockAuth = Mockery::mock('overload:Illuminate\Support\Facades\Auth');
        $mockAuth->shouldReceive('attempt')->once()->with(['email' => 'test@example.com', 'password' => 'password'])->andReturn(false);

        $mockSession = Mockery::mock('overload:Illuminate\Session\Store');
        $mockSession->shouldReceive('flash')->once()->with('status', 'Incorrect username or password!');

        $mockRedirectResponse = Mockery::mock(RedirectResponse::class);
        $mockRedirectResponse->shouldReceive('route')->once()->with('pages.login')->andReturn('redirect response');

        $loginController = new LoginController();
        $result = $loginController->login($request);

        $this->assertEquals('redirect response', $result);
    }

    public function testLogout()
    {
        $mockSession = Mockery::mock('overload:Illuminate\Session\Store');
        $mockSession->shouldReceive('flush')->once();

        $mockAuth = Mockery::mock('overload:Illuminate\Support\Facades\Auth');
        $mockAuth->shouldReceive('logout')->once();

        $mockRedirectResponse = Mockery::mock(RedirectResponse::class);
        $mockRedirectResponse->shouldReceive('route')->once()->with('pages.landing')->andReturn('redirect response');

        $loginController = new LoginController();
        $result = $loginController->logout();

        $this->assertEquals('redirect response', $result);
    }
}
