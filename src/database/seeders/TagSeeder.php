<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class TagSeeder extends Seeder
{

    private $tags = array("Las mejores ofertas esta Navidad", "Novedades", "Productos destacados", "Los más vendidos");

    private function saveTags() {
        foreach ($this->tags as $tagName) {
            $tag = new Category();
            $tag->name = $tagName;
            $tag->type = 'T';
            $tag->parent_id = null;
            $tag->save();
        }
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->where('type', '=', 'T')->delete();

        $this->saveTags();
    }
    
}
