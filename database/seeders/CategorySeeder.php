<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    private $category;

    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    public function run(): void
    {
        $categories = [
            [
                'name' => 'Travel',
                'created_at' => NOW(),
                'updated_at' => NOW()
            ],
            [
                'name' => 'Food',
                'created_at' => NOW(),
                'updated_at' => NOW()
            ],
            [
                'name' => 'Lifestyle',
                'created_at' => NOW(),
                'updated_at' => NOW()
            ],
            [
                'name' => 'Music',
                'created_at' => NOW(),
                'updated_at' => NOW()
            ],
        ];

        $this->category->insert($categories);
    }
}
