<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class LandingController extends Controller
{
    public function landing(Request $request)
    {
        $tags = $this->getTagValues();
        return view('pages.landing', compact('tags'));
    }

    private function getActiveTagList()
    {
        $tags = file_get_contents(__DIR__ . '/../../../activeTags.json');
        $tags = json_decode($tags, true);

        return $tags['activeTags'];
    }

    private function getTagValues()
    {
        $tags = $this->getActiveTagList();

        for ($i = 0; $i < count($tags); $i++) {
            $tags[$i]['name'] = Category::where('id', $tags[$i]['name'])->value('name');

            for ($j = 0; $j < count($tags[$i]['productsId']); $j++) {
                $tags[$i]['productsId'][$j] = Product::where('id', $tags[$i]['productsId'][$j])->get();
            }
        }

        return $tags;
    }
}
