<?php

use Illuminate\Database\Seeder;

class TemplateDatabaseSeeder extends Seeder
{
    public function run()
    {
        DB::table('translator_translations')->insert([
            [
                'locale' => config('app.locale'),
                'namespace' => '*',
                'group' => 'google',
                'item' => 'site_abr',
                'text' => 'Azizi',
            ],
            [
                'locale' => config('app.locale'),
                'namespace' => '*',
                'group' => 'google',
                'item' => 'advertise',
                'text' => 'Advertise',
            ],
            [
                'locale' => config('app.locale'),
                'namespace' => '*',
                'group' => 'google',
                'item' => 'more',
                'text' => 'More',
            ],
            [
                'locale' => config('app.locale'),
                'namespace' => '*',
                'group' => 'google',
                'item' => 'thats_all_we_know',
                'text' => 'That’s all we know.',
            ],
            [
                'locale' => config('app.locale'),
                'namespace' => '*',
                'group' => 'google',
                'item' => 'thats_an_error',
                'text' => 'That’s an error.',
            ],
        ]);
    }
}