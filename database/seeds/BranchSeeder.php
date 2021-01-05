<?php

use Illuminate\Database\Seeder;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Branch::unguard();

        $branch = \App\Branch::create([
           'name' => 'UKM Cisaat',
           'code' => 'I',
           'address' => 'Indonesia',
           'pic_name' => 'Bpk Budi',
           'pic_phone_number' => '0856789456',
            'is_central' => true
        ]);

        // $branch->teachers()->saveMany(factory(\App\Teacher::class, 10)->make());
        //
        // factory(\App\ProductCategory::class, 1)->create(['name' => 'Buah-buahan'])->each(function ($category) use ($branch) {
        //     factory(\App\Product::class, 25)
        //         ->state('fruit')
        //         ->create(['category_id' => $category->id])
        //         ->each(function ($product) use ($branch) {
        //             factory(\App\ProductStock::class, 1)->create(['product_id' => $product->id, 'branch_id' => $branch->id]);
        //         });
        // });
        //
        // factory(\App\Branch::class, 5)->create()->each(function($branch){
        //     $branch->teachers()->saveMany(factory(\App\Teacher::class, 10)->make());
        //
        //     // Create Admin User
        //     $user = $branch->users()->save(factory(\App\User::class)->make());
        //     $user->assignRole('Admin');
        // });

    }
}
