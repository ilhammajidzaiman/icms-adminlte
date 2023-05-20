<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use App\Models\BlogCategory;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BlogCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        BlogCategory::create([
            'uuid'          => Str::uuid(),
            'name'          => 'Berita',
            'slug'          => 'berita',
        ]);

        BlogCategory::create([
            'uuid'          => Str::uuid(),
            'name'          => 'Informasi',
            'slug'          => 'informasi',
        ]);

        BlogCategory::create([
            'uuid'          => Str::uuid(),
            'name'          => 'Tutorial',
            'slug'          => 'tutorial',
        ]);
    }
}
