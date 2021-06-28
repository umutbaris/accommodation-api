<?php

use Illuminate\Database\Seeder;
use App\Category;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            "Hotel",
            "Alternative",
            "Hostel",
            "Lodge",
            "Resort",
            "Guest House"
        ];

        foreach ($categories as $category) {
            Category::create(
                [
                    "name" => $category,
                    "slug" => Str::slug($category, "-")
                ]
            );
        }
    }
}
