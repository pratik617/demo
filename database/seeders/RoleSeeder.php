<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            [
                'name' => 'admin',
                'guard_name' => 'web'
            ],
            [
                'name' => 'staff',
                'guard_name' => 'web'
            ],
            [
                'name' => 'customer',
                'guard_name' => 'web'
            ],
        ];
        
        foreach ($roles as $role) {
            Role::firstOrCreate($role);
        }
    }
}
