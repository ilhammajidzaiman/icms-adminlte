<?php

namespace Database\Seeders;

use App\Models\Config;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Config::create([
            'uuid'          => Str::uuid(),
            'app'           => 'app name',
            'detail'        => 'app detail',
            'copyright'     => 'app copyright',
            'file'          => 'logo.svg',
        ]);
    }
}
