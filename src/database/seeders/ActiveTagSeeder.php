<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Category;
use App\Models\Product;
use Exception;

use Illuminate\Support\Facades\Log;

class ActiveTagSeeder extends Seeder
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

    private function saveRelationshipTagsProducts()
    {
        $tagsData = $this->getActiveTagList();
        foreach ($tagsData as $activeTag) {
            if ($activeTag['amount'] > Product::count()) {
                $errorMessage = 'No hi ha productes suficients.';
                Log::error($errorMessage);
                throw new Exception($errorMessage);
            }

            for ($i = 0; $i < $activeTag['amount']; $i++) {
                $tag = Category::where('id', $activeTag['id'])->first();
                $product = Product::inRandomOrder()->first();
                $tag->products()->attach($product->id, [
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
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
