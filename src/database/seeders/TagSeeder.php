<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->where('type', '=', 'T')->delete();

        $tags = array("Las mejores ofertas esta Navidad", "Novedades", "Productos destacados", "Los más vendidos");
        foreach ($tags as $tagName) {
            $tag = new Category();
            $tag->name = $tagName;
            $tag->type = 'T';
            $tag->parent_id = null;
            $tag->save();
        }

        $tags = file_get_contents(__DIR__ . '/../../../activeTags.json');
        $tags = json_decode($tags, true);
    }
}
