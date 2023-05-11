<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;


class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::create([
            'firstname' => 'John', 
            'lastname' => 'Doe',
            'email' => 'john@gmail.com',
            'username' => 'johndoe', 
            'password' => Hash::make('password')
        ]);
    }
}