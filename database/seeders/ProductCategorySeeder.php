<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker      = Faker::create('App/Product');

        foreach (range(1, 10) as $i) {
            $cats = DB::table('categories')->select("id")->get();
            $parent_cat = rand(0,1) ? (count($cats) ? $cats[rand(0,count($cats)-1)]->id : null) : null;
            DB::table('categories')->insert([
                'name'         => strtoupper($faker->sentence(1)),
                'parent_category_id' => $parent_cat,
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()
            ]);
        }

        $faker      = Faker::create('App/Category');

        $cats = DB::table('categories')->select("id")->get();
        foreach (range(1, 10) as $i) {
            $cat = rand(0,1) ? (count($cats) ? $cats[rand(0,count($cats)-1)]->id : null) : null;
            DB::table('products')->insert([
                'name'         => strtoupper($faker->sentence(1)),
                'description'   => implode($faker->paragraphs(1)),
                'price'   => $faker->randomFloat(3, 0, 1000),
                'category_id' => $cat,
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()
            ]);
        }
    }
}
