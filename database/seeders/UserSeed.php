<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // first user
        $user = new User();
        $user->password = Hash::make('123123');
        $user->name = 'ibtisam';
        $user->email = 'ibtisam@bookspreview.com';
        $user->save();

    }
}
