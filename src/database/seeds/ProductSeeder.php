<?php

namespace Database\Seeders;

use Carbon\Carbon;
use DB;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * @throws \Exception
     */
    public function run()
    {
        $faker = Faker::create('App\Modules\Products\Models\Product');

        for ($i = 1; $i <= 10000; $i++) {
            DB::table('products')->insert([
                'title' => $faker->sentence,
                'price' => $faker->randomDigit,
                'quantity' => random_int(1,600),
                'sale' => 0,
                'is_sale' => 0,
                'product_category_id' => random_int(1,4),
                'description' => $faker->paragraph,
                'user_id' => 1,
                'status' => 'ACTIVE',
                'shop_id' => 1,
                'brand_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
