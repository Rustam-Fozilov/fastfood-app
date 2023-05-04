<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert(
            [
                'name' => 'Hamburger',
                'price' => 799,
                'description' => 'lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
                'image_name' => 'hamburger.jpg',
            ],
        );

        DB::table('products')->insert(
            [
                'name' => 'Pizza',
                'price' => 599,
                'description' => 'lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
                'image_name' => 'pizza.jpg',
            ],
        );

        DB::table('products')->insert(
            [
                'name' => 'Hotdog',
                'price' => 699,
                'description' => 'lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
                'image_name' => 'hotdog.jpg',
            ],
        );

        DB::table('products')->insert(
            [
                'name' => 'Fries',
                'price' => 299,
                'description' => 'lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
                'image_name' => 'fries.jpg',
            ],
        );
    }
}
