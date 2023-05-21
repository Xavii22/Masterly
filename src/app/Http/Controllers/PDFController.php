<?php

namespace App\Http\Controllers;

use App\Http\Controllers\ProfileController;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class PDFController extends Controller
{
    public function pdf(Request $request)
    {
        $profileController = new ProfileController();
        $orders = $profileController->getOrderHistory('buyer_id');
        
        $order = $orders[$request->query('pdfId')][1];

        $total = 0;
        foreach ($order as $products) {
            foreach ($products[0] as $product) {
                $total += $product->price;
            }
        }

        $pdf = PDF::loadView('pages.pdf', compact('order', 'total'));

        return $pdf->download('archivo.pdf');
    }
}
