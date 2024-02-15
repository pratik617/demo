<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
use App\Models\User;
use App\Models\Role;

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

        // DB::statement('SET FOREIGN_KEY_CHECKS=0');

        // User::truncate();
        
        $this->call([
            RoleSeeder::class,
        ]);

        $users = \App\Models\User::factory(1000)->create();

        $role = Role::findByName('customer');
        
        $role->users()->attach($users);
    }
}
