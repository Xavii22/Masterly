<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;
use App\Models\Category;
use Illuminate\Support\Facades\Log;

class LandingController extends Controller
{

    private function getActiveTagList()
    {
        $tags = file_get_contents(base_path() . env('ACTIVE_TAGS'));
        $tags = json_decode($tags, true);

        if ($tags == null) {
            Log::error('File not found');
        }

        return $tags['activeTags'];
    }

    private function getTagValues()
    {
        $activeTags = $this->getActiveTagList();
        $tagProducts = array();

        foreach ($activeTags as $key => $activeTag) {
            $tagProducts[$key]['id'] = $activeTag['id'];
            $tagProducts[$key]['name'] = Category::where('id', $activeTag['id'])->value('name');
            $tagProducts[$key]['products'] = Product::whereHas('categories', function ($query) use ($activeTag) {
                $query->where('categories.type', 'T')
                      ->where('categories.id', $activeTag['id']);
            })->get();
        }

        if (count($tagProducts) == 0) {
            Log::error('No tag products found.');
        }

        return $tagProducts;
    }

    public function landing()
    {
        $tags = $this->getTagValues();
        return view('pages.landing', compact('tags'));
    }
}
