<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder {
    public function run(): void {
        User::create([
            'name'     => 'CineX Admin',
            'email'    => 'admin@cinex.com',
            'password' => Hash::make('admin123'),
            'is_admin' => true,
            'phone'    => '0300-0000000',
        ]);
    }
}