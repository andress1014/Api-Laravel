<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class TodosSeeders extends Seeder
{
    public function run()
    {
        $useradmin = User::create([
            'name' => 'Admin',
            'email' => 'admin@admin',
            'password' => Hash::make('admin'),
            'fullacces' => 'yes',
            'codigo' => 'adm1'
        ]);
        $user1=User::create([
            'name' => 'Usuario',
            'email' => 'user@user',
            'password' => Hash::make('user'),
            'fullacces' => 'no',
            'codigo' => 'casa1'
        ]);
    }
}
