<?php

use Illuminate\Database\Seeder;

class PluginsDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $defaultLocale = config('app.locale');
        \DB::table('engines')->insert([
            'slug' => 'wiki',
            'name' => 'wiki',
            'key' => 'xxxxxx:xxx',
            'view' => 'wikiresults',
            'controller' => '\AziziSearchEngineStarter\Http\Controllers\plugins\wikipedia\WikiController',
            'edit_route' => 'wikipedia.admin.get',
            'per_page' => 10,
            'order'     => 1001,
            'turn'     => 1,
        ]);

        \DB::table('translator_translations')->insert([
            [
                'locale' => $defaultLocale,
                'namespace' => '*',
                'group' => 'wikipedia-plugin',
                'item' => 'information-title',
                'text' => 'Information :title',
            ],
            [
                'locale' => $defaultLocale,
                'namespace' => '*',
                'group' => 'wikipedia-plugin',
                'item' => 'read-more',
                'text' => 'read more &raquo;',
            ],
            [
                'locale' => $defaultLocale,
                'namespace' => '*',
                'group' => 'wikipedia-plugin',
                'item' => 'source',
                'text' => 'Source: en.wikipedia.org/wiki/:slug',
            ],
            [
                'locale' => $defaultLocale,
                'namespace' => '*',
                'group' => 'wikipedia-plugin',
                'item' => 'previous',
                'text' => '« Previous',
            ],
            [
                'locale' => $defaultLocale,
                'namespace' => '*',
                'group' => 'wikipedia-plugin',
                'item' => 'next',
                'text' => 'Next »',
            ],
        ]);
    }
}
