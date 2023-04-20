<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Store;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class StoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('stores')->delete();
        $storeName = '';
        
        do {
            $storeName = fake()->company();
        }
        while (Str::contains($storeName, '-'));

        $users = User::distinct()->take(5)->get();
        foreach ($users as $user) { 
            Store::create([
                'name' => $storeName,
                'user_id' => $user->id
            ]);
        }
    }
}
