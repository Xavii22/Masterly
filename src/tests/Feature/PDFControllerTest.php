<?php

namespace Tests\Feature\Controllers;

use Tests\TestCase;
use Barryvdh\DomPDF\Facade as PDF;

class PDFControllerTest extends TestCase
{
    /**
     * Test the pdf method of the PDFController.
     *
     * @return void
     */
    public function testPdf()
    {
        // Mock the ProfileController
        $profileControllerMock = $this->mock(\App\Http\Controllers\ProfileController::class);
        $profileControllerMock->shouldReceive('getOrderHistory')->once()->with('buyer_id')->andReturn([
            'order1' => [
                1 => [
                    [/* products array */],
                    true,
                    1,
                    'Store 1',
                    0
                ]
            ]
        ]);

        // Create a fake request with the query parameter 'pdfId'
        $request = \Illuminate\Http\Request::create('/pdf', 'GET', ['pdfId' => 'order1']);

        // Mock the PDF facade
        $pdfMock = $this->mock(PDF::class);
        $pdfMock->shouldReceive('loadView')->once()->with('pages.pdf', \Mockery::subset(['order', 'total']))->andReturn($pdfMock);
        $pdfMock->shouldReceive('download')->once()->with('archivo.pdf');

        // Send a GET request to the pdf endpoint
        $response = $this->app->handle($request);

        // Assert that the response is successful
        $this->assertEquals(200, $response->getStatusCode());
    }
}
