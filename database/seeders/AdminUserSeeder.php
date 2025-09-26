<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $email = 'admin@renzman.com';
        $user = User::where('email', $email)->first();

        if (!$user) {
            $user = User::create([
                'name' => 'Admin',
                'email' => $email,
                'password' => Hash::make('password'),
            ]);
        }

        // If role column exists, ensure this user is an admin
        if (Schema::hasColumn('users', 'role')) {
            $user->role = 'admin';
            $user->save();
        }
    }
}
