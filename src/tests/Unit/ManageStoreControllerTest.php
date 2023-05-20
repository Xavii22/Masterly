<?php

namespace Tests\Unit\Controllers;

use App\Http\Controllers\ManageStoreController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;
use Mockery;


class ManageStoreControllerTest extends TestCase
{
    public function testGetCurrentUrlWithValidUrl()
    {
        $mockRequest = $this->mock(Request::class);
        $mockRequest->shouldReceive('url')->once()->andReturn('http://example.com/stores/123');

        $result = ManageStoreController::getCurrentUrl();

        $this->assertEquals('123', $result);
    }

    public function testGetCurrentUrlWithInvalidUrl()
    {
        $mockRequest = $this->mock(Request::class);
        $mockRequest->shouldReceive('url')->once()->andReturn('http://example.com');

        $mockLog = $this->mock(Log::class);
        $mockLog->shouldReceive('error')->once()->with('Url not set correctly');

        $result = ManageStoreController::getCurrentUrl();

        $this->assertNull($result);
    }
}
