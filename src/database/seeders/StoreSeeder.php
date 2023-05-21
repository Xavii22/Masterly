<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Store;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class StoreSeeder extends Seeder
{

    private function generateRandomStoreName()
    {
        $storeName = '';

        do {
            $storeName = fake()->company();
        } while (Str::contains($storeName, '-') || Str::contains($storeName, ',') || Str::contains($storeName, '.'));

        return $storeName;
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('stores')->delete();
        
        $users = User::distinct()->take(5)->get();
        foreach ($users as $user) {
            Store::create([
                'name' => $this->generateRandomStoreName(),
                'user_id' => $user->id
            ]);
        }
    }
}
