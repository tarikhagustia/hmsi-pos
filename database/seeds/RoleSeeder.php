<?php

use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Role::unguard();

        \App\Role::create([
           'name' => 'Super Admin'
        ]);

        \App\Role::create([
            'name' => 'Admin'
        ]);

    }
}
