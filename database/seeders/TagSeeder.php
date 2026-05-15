<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    public function run(): void
    {
        $tags = [
            ['name' => 'Bug',          'color' => 'red'],
            ['name' => 'Melhoria',     'color' => 'blue'],
            ['name' => 'Urgente',      'color' => 'orange'],
            ['name' => 'Documentação', 'color' => 'purple'],
            ['name' => 'Infraestrutura', 'color' => 'yellow'],
            ['name' => 'Segurança',    'color' => 'pink'],
            ['name' => 'Dúvida',       'color' => 'green'],
            ['name' => 'Outros',       'color' => 'indigo'],
        ];

        foreach ($tags as $tag) {
            Tag::firstOrCreate(['name' => $tag['name']], ['color' => $tag['color']]);
        }
    }
}
