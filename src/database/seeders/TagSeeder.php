<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tags = array("Las mejores ofertas esta Navidad", "Novedades", "Productos destacados", "Los más vendidos");
        foreach ($tags as $tagName) {
            $tag = new Category();
            $tag->name = $tagName;
            $tag->type = 'T';
            $tag->parent_id = null;
            $tag->save();
        }
    }
}
