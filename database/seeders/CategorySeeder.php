<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Infraestrutura', 'color' => '#3b82f6'],
            ['name' => 'Software', 'color' => '#8b5cf6'],
            ['name' => 'Hardware', 'color' => '#f59e0b'],
            ['name' => 'Rede', 'color' => '#10b981'],
            ['name' => 'Acesso e Permissões', 'color' => '#ef4444'],
            ['name' => 'Financeiro', 'color' => '#06b6d4'],
            ['name' => 'RH', 'color' => '#ec4899'],
            ['name' => 'Outros', 'color' => '#6b7280'],
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(
                ['slug' => Str::slug($category['name'])],
                [
                    'name' => $category['name'],
                    'slug' => Str::slug($category['name']),
                    'color' => $category['color'],
                    'active' => true,
                ]
            );
        }
    }
}
