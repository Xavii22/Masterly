<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Log;

class LandingController extends Controller
{
    private function getActiveTagList()
    {
        $tags = file_get_contents(__DIR__ . '/../../../activeTags.json');
        $tags = json_decode($tags, true);

        if ($tags == null) {
            Log::error('File not found');
        }

        return $tags['activeTags'];
    }

    private function getTagValues()
    {
        $tags = $this->getActiveTagList();

        for ($i = 0; $i < count($tags); $i++) {
            $tags[$i]['id'] = Category::where('id', $tags[$i]['id'])->value('name');

            for ($j = 0; $j < count($tags[$i]['productsId']); $j++) {
                $tags[$i]['productsId'][$j] = Product::where('id', $tags[$i]['productsId'][$j])->get();
            }
        }

        if (count($tags) == 0) {
            Log::error('No tags found.');
        }

        return $tags;
    }

    public function landing(Request $request)
    {
        $tags = $this->getTagValues();
        return view('pages.landing', compact('tags'));
    }
}
