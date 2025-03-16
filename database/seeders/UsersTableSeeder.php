<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        // Create roles
        $userRole = Role::firstOrCreate(['name' => 'user']);
        $adminRole = Role::firstOrCreate(['name' => 'admin']);

        // Insert user 'serius'
        $serius = DB::table('users')->insertGetId([
            'username' => 'serius',
            'password' => Hash::make('serius'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Assign role 'user' to 'serius'
        DB::table('model_has_roles')->insert([
            'role_id' => $userRole->id,
            'model_type' => 'App\Models\User',
            'model_id' => $serius,
        ]);

        // Insert user 'user'
        $user = DB::table('users')->insertGetId([
            'username' => 'user',
            'password' => Hash::make('user'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Assign role 'user' to 'user'
        DB::table('model_has_roles')->insert([
            'role_id' => $userRole->id,
            'model_type' => 'App\Models\User',
            'model_id' => $user,
        ]);

        // Insert user 'admin'
        $admin = DB::table('users')->insertGetId([
            'username' => 'admin',
            'password' => Hash::make('admin'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Assign role 'admin' to 'admin'
        DB::table('model_has_roles')->insert([
            'role_id' => $adminRole->id,
            'model_type' => 'App\Models\User',
            'model_id' => $admin,
        ]);
    }
}
