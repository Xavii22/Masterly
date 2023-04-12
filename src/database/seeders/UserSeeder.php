<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        self::generateUsers();
        $this->command->info('User table created succesfully');
    }

    private static function generateUsers()
    {
        DB::table('users')->delete();
        \App\Models\User::factory(10)->create();

        $u = new \App\Models\User(); 

        $u->name = 'user';
        $u->email = 'user@test.com';
        $u->password = Hash::make('12345'); 
        $u->save();
    }
}
