<?php

namespace Database\Seeders;

use App\Models\Departemen;
use App\Models\DosenWali;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\OperatorProdi;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        $user = User::create([
            'username' => '197404011999031002',
            'password' => Hash::make('password'),
            'role' => 'Operator Prodi',
        ]);

        $userDosen = User::create([
            'username' => '197308291998022001',
            'password' => Hash::make('password'),
            'role' => 'Dosen Wali',
        ]);

        $userDepartmen = User::create([
            'username' => '197312202000121001',
            'password' => Hash::make('password'),
            'role' => 'Departemen',
        ]);

        OperatorProdi::create([
            'nip' => $user->username,
            'nama' => 'Aris Puji Widodo',
            'email' => 'arispw@gmail.com', 
            'user_id' => $user->id
        ]);

        DosenWali::create([
            'nip' => $userDosen->username,
            'nama' => 'Beta Noranita',
            'email' => 'beta@gmail.com', 
            'user_id' => $userDosen->id
        ]);

        Departemen::create([
            'kodeDepartemen' => $userDepartmen->username,
            'namaDepartemen' => 'Informatika',
            'email' => 'informatika@gmail.com', 
            'user_id' => $userDepartmen->id
        ]);
    }
}
