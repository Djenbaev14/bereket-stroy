<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name'=>'admin',
            'username'=>'admin123',
            'password'=>Hash::make('admin')
        ]);

    }
}
