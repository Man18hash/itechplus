<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        User::updateOrCreate(
            // lookup by email…
            ['email' => 'admin@admin.com'],
            // …and set/update these attributes
            [
                'first_name' => 'Admin',
                'last_name'  => 'User',
                'password'   => '123',    // your mutator will auto-hash
                'is_admin'   => true,
            ]
        );
    }
}
