<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class TagSeeder extends Seeder
{

    //private $tags = array("Las mejores ofertas esta Navidad", "Novedades", "Productos destacados", "Los más vendidos");

    private function getTagList()
    {
        $tagsFile = fopen(base_path() . env('TAGS'), 'r');
        $tags = array();
        
        while (($row = fgetcsv($tagsFile)) !== false) {
            $tags[] = $row[0];
        }
        
        fclose($tagsFile);

        return $tags;
    }

    private function saveTags()
    {
        foreach ($this->getTagList() as $tagName) {
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
