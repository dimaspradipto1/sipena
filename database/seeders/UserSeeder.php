<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Super Admin SIPENA',
                'email' => 'superadmin@sipena.ac.id',
                'password' => Hash::make('password'),
                'role' => 'superadmin',
                'is_active' => true,
            ],
            [
                'name' => 'Admin BKAK',
                'email' => 'adminbkak@sipena.ac.id',
                'password' => Hash::make('password'),
                'role' => 'adminbkak',
                'is_active' => true,
            ],
            [
                'name' => 'Kepala Bidang Kemahasiswaan',
                'email' => 'kabid@sipena.ac.id',
                'password' => Hash::make('password'),
                'role' => 'kabid',
                'is_active' => true,
            ],
            [
                'name' => 'Staff Kemahasiswaan',
                'email' => 'staff@sipena.ac.id',
                'password' => Hash::make('password'),
                'role' => 'staff',
                'is_active' => true,
            ],
            [
                'name' => 'Pimpinan Universitas',
                'email' => 'pimpinan@sipena.ac.id',
                'password' => Hash::make('password'),
                'role' => 'pimpinan',
                'is_active' => true,
            ],
            [
                'name' => 'Admin Program Studi',
                'email' => 'prodi@sipena.ac.id',
                'password' => Hash::make('password'),
                'role' => 'prodi',
                'is_active' => true,
            ],
            [
                'name' => 'Dosen Pendamping',
                'email' => 'dosenpendamping@sipena.ac.id',
                'password' => Hash::make('password'),
                'role' => 'dosenpendamping',
                'is_active' => true,
            ],
            [
                'name' => 'Mahasiswa Berprestasi',
                'email' => 'mahasiswa@sipena.ac.id',
                'password' => Hash::make('password'),
                'role' => 'mahasiswa',
                'is_active' => true,
            ],
        ];

        foreach ($users as $userData) {
            User::updateOrCreate(
                ['email' => $userData['email']],
                $userData
            );
        }
    }
}
