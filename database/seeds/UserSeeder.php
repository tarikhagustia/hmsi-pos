<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\User::unguard();

        \App\User::create([
            'branch_id' => null,
            'role_id' => \App\Role::where('name', 'Super Admin')->first()->id,
            'name' => 'Administrator',
            'email' => 'sudo@example.com',
            'password' => \Illuminate\Support\Facades\Hash::make('Password123'),
            'remember_token' => \Illuminate\Support\Str::random(10)
        ]);

        \App\User::create([
            'branch_id' => 1,
            'role_id' => \App\Role::where('name', 'Admin')->first()->id,
            'name' => 'UKM Cisaat',
            'email' => 'ukm_cisaat@hmsi.com',
            'password' => \Illuminate\Support\Facades\Hash::make('Password123'),
            'remember_token' => \Illuminate\Support\Str::random(10)
        ]);

        $this->command->info('Creating sample users...');
        $this->command->table(['level', 'email', 'password'], [
            ['Super User', 'sudo@example.com', 'Password123'],
            ['Admin UKM Cisaat', 'ukm_cisaat@hmsi.com', 'Password123']
        ]);
    }
}
