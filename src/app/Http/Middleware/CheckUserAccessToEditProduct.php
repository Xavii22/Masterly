<?php

namespace App\Http\Middleware;

use App\Models\Product;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Store;

class CheckUserAccessToEditProduct
{

    private function checkUserAccessToProduct($productId, $userId)
    {
        $product = Product::where('id', $productId)->first();
        $store = Store::where('id', $product->store_id)->first();
        
        if ($store->user_id == $userId) {
            return true;
        }

        return false;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $productId = $request->route('id');
        $user = $request->user();

        if ($this->checkUserAccessToProduct($productId, $user->id)) {
            return $next($request);
        }

        return redirect()->route('home')->with('error', 'You are not authorized to access this page.');
    }
}
