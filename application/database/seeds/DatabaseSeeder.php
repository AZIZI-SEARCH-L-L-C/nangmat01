<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call('AlltablesSeeder');

        $this->command->info('All tables seeded!');
    }

}

class AlltablesSeeder extends Seeder {

    public function run()
    {
        // default settings
        DB::table('settings')->delete();
        DB::table('settings')->insert(['name' => 'siteName', 'value' => 'Azizi Search Engine']);
        DB::table('settings')->insert(['name' => 'siteDescription', 'value' => 'web search engine']);
        DB::table('settings')->insert(['name' => 'default', 'value' => 'web']);
        DB::table('settings')->insert(['name' => 'resultsInfo', 'value' => 1]);
        // DB::table('settings')->insert(['name' => 'thumbnailImage', 'value' => 'block']);
        DB::table('settings')->insert(['name' => 'keywordsSuggestion', 'value' => 1]);
        DB::table('settings')->insert(['name' => 'relatedKeywords', 'value' => 1]);
        DB::table('settings')->insert(['name' => 'speachInput', 'value' => 1]);
        DB::table('settings')->insert(['name' => 'chooseLanguage', 'value' => 1]);
        DB::table('settings')->insert(['name' => 'advertisements', 'value' => 1]);
        DB::table('settings')->insert(['name' => 'takeFromAdvertisements', 'value' => 3]);
        DB::table('settings')->insert(['name' => 'defaultLogoType', 'value' => 0]);
        DB::table('settings')->insert(['name' => 'defaultLogoContent', 'value' => 'Azizi Search Engine']);
        DB::table('settings')->insert(['name' => 'ChangeLogoTime', 'value' => 3600]);
        DB::table('settings')->insert(['name' => 'autoLocalization', 'value' => 1]);
        DB::table('settings')->insert(['name' => 'localizationMode', 'value' => 1]);
        DB::table('settings')->insert(['name' => 'locale', 'value' => 'en_GB']);
        DB::table('settings')->insert(['name' => 'orderBy', 'value' => 1]);
        DB::table('settings')->insert(['name' => 'resultsTarget', 'value' => '_blank']);
        DB::table('settings')->insert(['name' => 'safeSearch', 'value' => 1]);
        DB::table('settings')->insert(['name' => 'perPageWeb', 'value' => 10]);
        DB::table('settings')->insert(['name' => 'perPageImages', 'value' => 50]);
        DB::table('settings')->insert(['name' => 'imagesLayout', 'value' => 0]);
        DB::table('settings')->insert(['name' => 'brandBlock', 'value' => 'none']);
        DB::table('settings')->insert(['name' => 'adsenseBlock', 'value' => 'block']);
        DB::table('settings')->insert(['name' => 'documentsFilter', 'value' => 0]);
        DB::table('settings')->insert(['name' => 'countryFilter', 'value' => 0]);
        DB::table('settings')->insert(['name' => 'dateFilter', 'value' => 1]);
        DB::table('settings')->insert(['name' => 'firstCountries', 'value' => 'UK,US']);
        DB::table('settings')->insert(['name' => 'countries', 'value' => 'UK,US,FR']);
        DB::table('settings')->insert(['name' => 'fileTypes', 'value' => 'pdf,doc']);
        DB::table('settings')->insert(['name' => 'keepFilters', 'value' => 1]);
        DB::table('settings')->insert(['name' => 'imgColorFilter', 'value' => 1]);
        DB::table('settings')->insert(['name' => 'imgTypeFilter', 'value' => 1]);
        DB::table('settings')->insert(['name' => 'imgLicenseFilter', 'value' => 1]);
        DB::table('settings')->insert(['name' => 'imgSizeFilter', 'value' => 1]);
        DB::table('settings')->insert(['name' => 'videosPricingFilter', 'value' => 1]);
        DB::table('settings')->insert(['name' => 'videosLengthFilter', 'value' => 1]);
        DB::table('settings')->insert(['name' => 'videosResolutionFilter', 'value' => 1]);
        DB::table('settings')->insert(['name' => 'cache', 'value' => 1]);
        DB::table('settings')->insert(['name' => 'cacheTime', 'value' => 1440]);
        DB::table('settings')->insert(['name' => 'defferCacheTime', 'value' => 1440]);
        DB::table('settings')->insert(['name' => 'webPagination', 'value' => 2]);
        DB::table('settings')->insert(['name' => 'imagesPagination', 'value' => 3]);
        DB::table('settings')->insert(['name' => 'imagesPosition', 'value' => 2]);
        DB::table('settings')->insert(['name' => 'newsPosition', 'value' => 2]);
        DB::table('settings')->insert(['name' => 'imagesAllturn', 'value' => 0]);
        DB::table('settings')->insert(['name' => 'newsAllturn', 'value' => 0]);
        DB::table('settings')->insert(['name' => 'perPageVideos', 'value' => 50]);
        DB::table('settings')->insert(['name' => 'videosPagination', 'value' => 3]);
        DB::table('settings')->insert(['name' => 'newsPagination', 'value' => 2]);
        DB::table('settings')->insert(['name' => 'perPageNews', 'value' => 10]);
        DB::table('settings')->insert(['name' => 'newsThumbnail', 'value' => 0]);
        DB::table('settings')->insert(['name' => 'newsDateFormat', 'value' => 2]);
        DB::table('settings')->insert(['name' => 'newsDateFull', 'value' => 0]);
        DB::table('settings')->insert(['name' => 'newsDateFormatform', 'value' => 'F d - H:i']);
        DB::table('settings')->insert(['name' => 'showAllTypeOneTime', 'value' => 0]);
        DB::table('settings')->insert(['name' => 'videosAllturn', 'value' => 0]);
        DB::table('settings')->insert(['name' => 'videosPosition', 'value' => 3]);
        DB::table('settings')->insert(['name' => 'mathCalc', 'value' => 1]);
        DB::table('settings')->insert(['name' => 'timeZone', 'value' => 1]);
        DB::table('settings')->insert(['name' => 'facts', 'value' => 1]);
        DB::table('settings')->insert(['name' => 'usersLogin', 'value' => 1]);
        DB::table('settings')->insert(['name' => 'siteEmail', 'value' => '']);
        DB::table('settings')->insert(['name' => 'confirmEmail', 'value' => 0]);
        DB::table('settings')->insert(['name' => 'welcomeEmail', 'value' => 0]);
        DB::table('settings')->insert(['name' => 'translations', 'value' => 1]);
        DB::table('settings')->insert(['name' => 'entities', 'value' => 1]);
        DB::table('settings')->insert(['name' => 'entitiesNum', 'value' => 3]);
        DB::table('settings')->insert(['name' => 'entityTruncate', 'value' => 120]);
        DB::table('settings')->insert(['name' => 'entitesAllowed', 'value' => 'Generic,Place,Media,Organization,Attraction,City,Continent,Country,Hotel,House,LocalBusiness,Locality,MinorRegion,Neighborhood,Other,PointOfInterest,PostalCode,RadioStation,Region,LocalBusiness,Restaurant,State,StreetAddress,SubRegion,TouristAttraction,Travel,Book,Movie,TelevisionSeason,TelevisionShow,VideoGame,Event,Actor,Artist,Attorney,CollegeOrUniversity,School,Speciality,Animal,Car,Product,Drug,Food,SportsTeam,CollegeOrUniversity,MusicRecording,Person']);
        DB::table('settings')->insert(['name' => 'companyName', 'value' => 'my company']);
        DB::table('settings')->insert(['name' => 'siteDomain', 'value' => 'mydomain.com']);
        DB::table('settings')->insert(['name' => 'initialCost0', 'value' => 0.12]);
        DB::table('settings')->insert(['name' => 'initialCost1', 'value' => 0.05]);
        DB::table('settings')->insert(['name' => 'initialCost2', 'value' => 0.89]);
        DB::table('settings')->insert(['name' => 'costPerDecimals', 'value' => 2]);
        DB::table('settings')->insert(['name' => 'budgetMin', 'value' => 5]);

        DB::table('settings')->insert(['name' => 'googleWebCsePublicKey', 'value' => '006010194534762694787:1zmqadtc44q']);
        DB::table('settings')->insert(['name' => 'googleImagesCsePublicKey', 'value' => '006010194534762694787:1zmqadtc44q']);

        DB::table('settings')->insert(['name' => 'front-paper', 'value' => 1]);

        DB::table('settings')->insert(['name' => 'logNotifications', 'value' => 1]);

        DB::table('settings')->insert(['name' => 'webPaginationFull', 'value' => 0]);
        DB::table('settings')->insert(['name' => 'webPaginationLimit', 'value' => 10]);
        DB::table('settings')->insert(['name' => 'imagesPaginationFull', 'value' => 0]);
        DB::table('settings')->insert(['name' => 'imagesPaginationLimit', 'value' => 10]);
        DB::table('settings')->insert(['name' => 'videosPaginationFull', 'value' => 0]);
        DB::table('settings')->insert(['name' => 'videosPaginationLimit', 'value' => 10]);
        DB::table('settings')->insert(['name' => 'newsPaginationFull', 'value' => 0]);
        DB::table('settings')->insert(['name' => 'newsPaginationLimit', 'value' => 10]);
        DB::table('settings')->insert(['name' => 'excTerr', 'value' => '']);

        DB::table('settings')->insert(['name' => 'min_payment', 'value' => '5']);
        DB::table('settings')->insert(['name' => 'max_payment', 'value' => '1000']);
        DB::table('settings')->insert(['name' => 'enable_comments', 'value' => '1']);
        DB::table('settings')->insert(['name' => 'enable_bookmarks', 'value' => '1']);
        DB::table('settings')->insert(['name' => 'ad_block_hometop_reserved1', 'value' => '']);
        DB::table('settings')->insert(['name' => 'ad_block_homebottom_reserved2', 'value' => '']);
        DB::table('settings')->insert(['name' => 'ad_block_resultstop_reserved3', 'value' => '']);
        DB::table('settings')->insert(['name' => 'ad_block_resultsbottom_reserved4', 'value' => '']);
        DB::table('settings')->insert(['name' => 'ad_block_resultsright_reserved5', 'value' => '']);
        DB::table('settings')->insert(['name' => 'approveAds', 'value' => '1']);

        // default Engines
        DB::table('engines')->delete();
        DB::table('engines')->insert(['name' => 'web', 'controller' => 'WebController', 'order' => 0, 'turn' => 1, ]);
        DB::table('engines')->insert(['name' => 'images', 'controller' => 'ImagesController', 'order' => 1, 'turn' => 1, ]);
        DB::table('engines')->insert(['name' => 'videos', 'controller' => 'VideosController', 'order' => 2, 'turn' => 1, ]);
        DB::table('engines')->insert(['name' => 'news', 'controller' => 'NewsController', 'order' => 3, 'turn' => 1, ]);
    }

}