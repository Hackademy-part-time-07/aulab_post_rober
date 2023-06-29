<?php

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            ['name' => 'Electrónica', 'description' => 'Categoría de productos electrónicos'],
            ['name' => 'Ropa', 'description' => 'Categoría de prendas de vestir'],
            // Agrega más categorías según tus necesidades
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
