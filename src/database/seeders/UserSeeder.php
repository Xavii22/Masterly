<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class UserSeeder extends Seeder
{

    private static function generateUsers()
    {
        DB::table('users')->delete();
        User::factory(10)->create();
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        self::generateUsers();
    }
}
