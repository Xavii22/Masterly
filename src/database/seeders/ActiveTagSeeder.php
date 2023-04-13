<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Category;
use App\Models\Product;

class ActiveTagSeeder extends Seeder
{

    private function saveRelationshipTagsProducts()
    {
        $tagsData = file_get_contents(__DIR__ . '/../../activeTags.json');
        $tagsData = json_decode($tagsData, true);
        foreach ($tagsData as $activeTags) {
            foreach ($activeTags as $activeTag) {
                $activeTagId = Category::where('id', $activeTag['id'])->firstOrFail()->id;
                foreach ($activeTag['productsId'] as $productsId) {
                    $product = Product::where('id', $productsId)->firstOrFail();
                    $product->categories()->attach($activeTagId, [
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('category_product')
            ->whereIn('category_id', function ($query) {
                $query->select('id')
                    ->from('categories')
                    ->where('type', '=', 'T');
            })
            ->delete();

        $this->saveRelationshipTagsProducts();
    }
}
