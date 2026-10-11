<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    public function run()
    {
        // Use raw SQL to insert SuperAdmin user with role_id resolved from roles table
        $roleId = DB::table('roles')->where('name','SuperAdmin')->value('id');
        if (! $roleId) {
            return;
        }

        $email = 'superadmin@example.com';
        $exists = DB::table('users')->where('email', $email)->exists();
        if ($exists) {
            return;
        }

        $password = Hash::make('password');

        DB::insert('INSERT INTO users (name,email,password,role_id,company_id,created_at,updated_at) VALUES (?,?,?,?,?,?,?)', [
            'Super Admin', $email, $password, $roleId, null, now(), now()
        ]);
    }
}
