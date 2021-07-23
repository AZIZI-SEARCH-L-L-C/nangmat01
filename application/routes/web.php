<?php
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

//Auth::loginUsingId(1);

Route::group([
    'prefix' => 'admin/install',
    'middleware' => [ 'NotInstalled' ]
], function(){
	
    Route::get('check', 'admin\InstallerController@get');
    Route::get('license', 'admin\InstallerController@license');
    Route::post('license', 'admin\InstallerController@postLicense');
    Route::get('database', 'admin\InstallerController@database');
    Route::post('database', 'admin\InstallerController@postDatabase');
    Route::get('general', 'admin\InstallerController@settings');
    Route::post('general', 'admin\InstallerController@postSettings');
    Route::get('complete', 'admin\InstallerController@complete');
    Route::post('complete', 'admin\InstallerController@postComplete');
});

Route::group([
	'middleware' => ['installed']
], function(){
	
	Route::group([
		'prefix' => 'admin',
		'as' => 'admin.',
		'middleware' => ['admin']
	], function(){
		Route::get('/', ['as' => 'home', 'uses' => 'admin\DashboardController@redirect']);
		Route::get('/logout', 'admin\loginController@logOut');
		Route::get('/dashboard', ['as' => 'dashboard', 'uses' => 'admin\DashboardController@get']);
		Route::post('/dashboard', 'admin\DashboardController@post');
		Route::get('/settings', 'admin\SettingsController@get');
		Route::post('/settings', 'admin\SettingsController@post');
		Route::get('/settings/social_login', 'admin\SettingsController@getSocialLogin');
		Route::post('/settings/social_login', 'admin\SettingsController@postSocialLogin');
		Route::get('/settings/payments_gateways', 'admin\SettingsController@getPaymentsGateways');
		Route::post('/settings/payments_gateways', 'admin\SettingsController@postPaymentsGateways');
		Route::get('/engines', ['as' => 'engines', 'uses' => 'admin\EnginesController@get']);
		Route::post('/engines', 'admin\EnginesController@post');
		Route::get('/engines/edit/{name}', ['as' => 'edit.engine', 'uses' => 'admin\EnginesController@getEdit']);
		Route::post('/engines/edit/{name}', 'admin\EnginesController@postEdit');
		
		Route::group([
			'prefix' => 'ads',
		], function(){
			Route::get('/simple', 'admin\AdvertisementsController@getSimpleAds')->name('simple');
			Route::get('/simple/remove/{id}', 'admin\AdvertisementsController@removeSimpleAds')->name('simpleAds.delete');
			Route::post('/simple', 'admin\AdvertisementsController@postSimpleAds');
			Route::get('/adsblocks', 'admin\AdvertisementsController@getAdsBlocks')->name('adsblocks.get');
			Route::post('/adsblocks', 'admin\AdvertisementsController@postAdsBlocks');
			Route::get('/primary/keywords', 'admin\AdvertisementsController@getPrimaryKeywords')->name('primary.keywords.get');
			Route::post('/primary/keywords', 'admin\AdvertisementsController@postPrimaryKeywords');
			Route::get('/primary/fields/factors', 'admin\AdvertisementsController@getFieldsfactors')->name('primary.factors.get');
			Route::post('/primary/fields/factors', 'admin\AdvertisementsController@postFieldsfactors');
			Route::get('/settings', 'admin\AdvertisementsController@getAdsSettings')->name('primary.factors.settings');
			Route::post('/settings', 'admin\AdvertisementsController@postAdsSettings');
			Route::get('/compains', 'admin\AdvertisementsController@getCompains')->name('searchcompains.get');
			Route::post('/compains', 'admin\AdvertisementsController@postCompains');
			Route::get('/compain/{id}', 'admin\AdvertisementsController@getAds')->name('searchads.get');
			Route::post('/compain/new', 'admin\AdvertisementsController@newCompain')->name('searchads.compain.new');
			Route::get('/compain/delete/{id}', 'admin\AdvertisementsController@deleteCompain')->name('searchads.compain.delete');
			Route::post('/compain/{id}/ads', 'admin\AdvertisementsController@postAds');
			Route::get('/compain/{id}/ad/new', 'admin\AdvertisementsController@getNewAd')->name('searchads.new.get');
			Route::post('/compain/{id}/ad/new', 'admin\AdvertisementsController@postNewAd');
			Route::get('/compain/{id}/ad/edit', 'admin\AdvertisementsController@getEditAd')->name('searchads.edit');
			Route::post('/compain/{id}/ad/edit', 'admin\AdvertisementsController@postEditAd');
			Route::get('/compain/delete/ad/{id}', 'admin\AdvertisementsController@deleteAd')->name('searchads.ad.delete');
		});
		
		Route::get('/advertiser', 'admin\AdvertiserController@get');
		Route::post('/advertiser', 'admin\AdvertiserController@post');
		Route::get('/engines/delete/{name}', 'admin\DeleteController@get');
		Route::post('/engines/delete/{name}', 'admin\DeleteController@post');
		Route::get('/logos', 'admin\LogosController@getAll');
		Route::post('/logos', 'admin\LogosController@postAll');
		Route::post('/logos/{name}/upload', 'admin\LogosController@upload');
		Route::get('/logos/{name}', 'admin\LogosController@get');
		Route::post('/logos/{name}', 'admin\LogosController@post');
		Route::post('/logos/newLogoText/{name}', 'admin\LogosController@addLogoText');
		Route::get('/languages', 'admin\LanguagesController@getAll');
		Route::post('/languages', 'admin\LanguagesController@postAll');
		Route::get('/languages/edit_phrases/{code}/{file}', 'admin\LanguagesController@getEditPhrases');
		Route::post('/languages/edit_phrases/{code}/{file}', 'admin\LanguagesController@postEditPhrases');
		Route::get('/templates', 'admin\TemplatesController@get');
		Route::get('/templates/{default}', 'admin\TemplatesController@setTemplate');
		Route::post('/templates/zip', 'admin\TemplatesController@upload');
		Route::get('/optimizer', 'admin\DashboardController@getOptimizer');
		Route::post('/optimizer', 'admin\DashboardController@optimizer');
		Route::get('/sites/ranked', 'admin\SitesController@getRankedSites')->name('sites.ranked');
//		Route::get('/sites/comments', 'admin\SitesController@getComments')->name('sites.comments');
		Route::get('/sites/comments/delete/{id}', 'admin\SitesController@deleteComment')->name('sites.comments.delete');
//		Route::get('/sites/bookmarks', 'admin\SitesController@getBookmarks')->name('sites.bookmarks');
        Route::get('/sites/bookmarks/delete/{id}', 'admin\SitesController@deleteBookmarks')->name('sites.bookmarks.delete');
		Route::get('/sites/new', 'admin\SitesController@approve')->name('sites.approve');
		Route::get('/sites/reject/{id}', 'admin\SitesController@reject')->name('sites.reject');
		Route::post('/sites/ranked', 'admin\SitesController@postRankedSites');
		Route::post('/sites/new', 'admin\SitesController@postApprove');
		Route::get('/sites/waiting', 'admin\SitesController@getWaitingSites')->name('sites.waiting');
		Route::get('/log', 'admin\LogController@get')->name('log');
		Route::post('/log', 'admin\LogController@post')->name('log.settings');
		Route::get('/queries', 'admin\DashboardController@getQueries')->name('stats.queries');
		Route::get('/admin/log', 'admin\DashboardController@getAdminLog')->name('admin.log');
		Route::get('/territories/block', 'admin\DashboardController@getBlockTerr')->name('blockTerr');
		Route::post('/territories/block', 'admin\DashboardController@postBlockTerr');
		Route::get('/territories/unblock', 'admin\DashboardController@unBlockTerr')->name('unblockTerr');

//        Route::get('/user', 'admin\UserInfoController@get');
//        Route::post('/user', 'admin\UserInfoController@post');

        Route::get('/users', 'admin\UserInfoController@get')->name('users');
        Route::get('/users/{id}', 'admin\UserInfoController@getUser')->name('users.one');
        Route::get('/users/{id}/campaigns', 'admin\UserInfoController@getCampaigns')->name('users.campaigns');
        Route::get('/users/{id}/comments', 'admin\UserInfoController@getComments')->name('users.comments');
        Route::get('/users/{id}/bookmarks', 'admin\UserInfoController@getBookmarks')->name('users.bookmarks');
        Route::get('/users/{id}/payments', 'admin\UserInfoController@getPayments')->name('users.payments');

		Route::get('/config/api/{name}', 'admin\ApiController@get')->name('apis.get');
		Route::post('/config/api/{name}', 'admin\ApiController@post');
//		Route::get('/config/settings', 'admin\ApiController@getApiSettings')->name('apis.settings.get');
//		Route::post('/config/settings', 'admin\ApiController@postApiSettings');

		Route::group(['prefix' => 'api', 'as' => 'api.'], function() {
			Route::get('/queries', 'admin\DashboardController@topQueries');
			Route::get('/queriesPerday', 'admin\DashboardController@QueriesPerday');
			Route::get('/countries', 'admin\DashboardController@countries');
			Route::get('/oss', 'admin\DashboardController@oss');
			Route::get('/devices', 'admin\DashboardController@devices');
			Route::get('/browsers', 'admin\DashboardController@browsers');
			Route::group(['prefix' => 'ajax', 'as' => 'ajax.'], function() {
				Route::post('/systemMode', ['as' => 'systemMode', 'uses' => 'admin\AjaxController@systemMode']);
				Route::post('/makeNotficationsRead', ['as' => 'makeNotficationsRead', 'uses' => 'admin\AjaxController@makeNotficationsRead']);
				Route::post('/approveAd', ['as' => 'searchads.approve', 'uses' => 'admin\AjaxController@approveAd']);
				Route::get('/users', ['as' => 'users', 'uses' => 'admin\AjaxController@users']);
			});
		});
		
		Route::group(['prefix' => 'plugins'], function() {
			Route::get('/', 'admin\PluginsController@installed');
			Route::post('/upload/zip', 'admin\PluginsController@upload');
			Route::post('/pluginManifest', 'admin\PluginsController@pluginManifest');
			Route::post('/install', 'admin\PluginsController@install');
			Route::get('/changeOption/{plugin}/{option}', 'admin\PluginsController@changeOption');
			Route::get('/activate/{plugin}', 'admin\PluginsController@activate');
			Route::post('/user/', 'admin\UserInfoController@post');

//			if(config('plugins')){
//				foreach(config('plugins') as $plugin){
//					foreach($plugin['routes']['admin'] as $route){
//						Route::{$route['type']}($route['route'], $route['action']);
//					}
//				}
//			}
		});
	});

	
	Route::group([
		'prefix' => 'admin',
		'as' => 'admin.',
		'middleware' => ['guest']
	], function(){
//		Route::get('/login', ['as' => 'login', 'uses' => 'admin\loginController@get']);
//		Route::post('/login', ['as' => 'login.post', 'uses' => 'admin\loginController@post']);
	});

	Route::group([
		
	], function() {
		
		Route::group([
			'prefix' => 'users',
			'middleware' => ['loggedIn', 'maintenance']
		], function() {
			Route::get('logout', ['as' => 'logout', 'uses' => 'UsersController@logout']);
			
			// profile
			Route::get('profile/edit/info', ['as' => 'profile.edit.info', 'uses' => 'UsersController@profileEdit']);
			Route::post('profile/edit/info', ['as' => 'profile.edit.info.post', 'uses' => 'UsersController@postProfileEdit']);
			Route::get('profile/edit/password', ['as' => 'profile.edit.pass', 'uses' => 'UsersController@profileEditPass']);
			Route::post('profile/edit/password', ['as' => 'profile.edit.pass.post', 'uses' => 'UsersController@postProfileEditPass']);
			Route::post('profile/edit/upload/thumbnail', ['as' => 'profile.edit.thumbnail.post', 'uses' => 'UsersController@uploadThumbnail']);
			Route::get('profile/bookmarks', ['as' => 'profile.bookmarks', 'uses' => 'BookmarksController@getBookmarks']);
			Route::get('profile/bookmarks/category/{id}', ['as' => 'profile.bookmarks.categories', 'uses' => 'BookmarksController@getBookmarksCats']);
			Route::get('profile/bookmarks/organize', ['as' => 'profile.bookmarks.organize', 'uses' => 'BookmarksController@bookmarksOrganize']);

			// ads
			// payments
			Route::get('ads/billing', ['as' => 'profile.edit.billing', 'uses' => 'ProccessPayments@billing']);
			Route::post('ads/billing', ['as' => 'profile.edit.billing.post', 'uses' => 'ProccessPayments@postBilling']);
			Route::get('ads/compains', ['as' => 'ads.compains', 'uses' => 'AdsController@compains']);
			Route::get('ads/compains/{id}', ['as' => 'ads.compains.ads', 'uses' => 'AdsController@manageCompainAds']);
			Route::get('ads/compains/{compain}/{ad}/makePayment', ['as' => 'ads.compains.ad.pay', 'uses' => 'AdsController@compainAdPay']);
			Route::get('ads/new', ['as' => 'ads.new', 'uses' => 'AdsController@createNewAdd']);
			Route::post('ads/new', ['as' => 'ads.new.post', 'uses' => 'AdsController@postCreateNewAdd']);
			Route::get('ads/{compainId}/{slug}/edit', ['as' => 'ads.compains.ad.edit', 'uses' => 'AdsController@adEdit']);
			Route::post('ads/{compainId}/{slug}/edit', ['as' => 'ads.compains.ad.edit.post', 'uses' => 'AdsController@postAdEdit']);
			Route::get('ads/payments', ['as' => 'ads.payments', 'uses' => 'AdsController@payments']);
			Route::post('ads/payment/card/new', ['as' => 'ads.payment.card.new.post', 'uses' => 'ProccessPayments@postNewCard']);
			Route::post('ads/payment/card', ['as' => 'ads.payment.card.post', 'uses' => 'ProccessPayments@postPaymentsCard']);
			Route::get('ads/payment/card/check', ['as' => 'ads.payment.card.check', 'uses' => 'ProccessPayments@checkCardPayment']);
			Route::post('ads/payment/paypal', ['as' => 'ads.payment.paypal.post', 'uses' => 'ProccessPayments@postPaymentsPaypal']);
			Route::get('ads/payments/paypalStatus', ['as' => 'ads.payments.process', 'uses' => 'ProccessPayments@proccessWithPaypal']);
			Route::get('ads/payments/receipt/{id}', ['as' => 'ads.payments.receipt.id', 'uses' => 'ProccessPayments@getReceipt']);
			
			// ajax S
			Route::post('api/ads/compain/create', ['as' => 'ajax.ads.compain.create', 'uses' => 'AdsController@postCreateCompain']);
			Route::post('api/ads/compains/{id}/{adId}', ['as' => 'ajax.ads.ad.editOne', 'uses' => 'AdsController@postManageCompainAds']);
			Route::post('api/ads/compains/ad/edit/active', ['as' => 'ajax.ads.toggelActive.ad', 'uses' => 'AdsController@postToggelAd']);

			// ajax data
			Route::get('api/ads/data/{name}', ['as' => 'ajax.ads.data', 'uses' => 'AdsController@getData']);

			// rank
            Route::get('api/updateRank', ['as' => 'updaterank', 'uses' => 'WebController@updateRank']);

            // bookmarks
            Route::get('api/bookmark', ['as' => 'bookmark', 'uses' => 'BookmarksController@bookmark']);
            Route::get('api/isBookmarked', ['as' => 'isbookmarked', 'uses' => 'BookmarksController@isbookmarked']);
            Route::get('api/bookmark/organize', ['as' => 'bookmark.organize', 'uses' => 'BookmarksController@setBookmarkOrganize']);
            Route::get('api/bookmark/new/categroy', ['as' => 'bookmark.new.category', 'uses' => 'BookmarksController@newCategory']);
            Route::get('api/bookmark/remove', ['as' => 'bookmark.remove', 'uses' => 'BookmarksController@removeBookmark']);
            Route::get('api/bookmark/move', ['as' => 'bookmark.move', 'uses' => 'BookmarksController@moveBookmark']);

            // comments
            Route::get('api/comments/post', ['as' => 'comments.post', 'uses' => 'UsersController@postComment']);
		});

        Route::get('api/comments', ['as' => 'comments', 'uses' => 'UsersController@comments']);
        Route::get('api/comments/count', ['as' => 'comments.count', 'uses' => 'UsersController@numOfComments']);

		// routes for public
		Route::group([
			'middleware' => ['guest', 'users']
		], function() {
			
			Route::get('password/reset/{token}', ['as' => 'password.reset.token', 'uses' => 'Auth\ResetPasswordController@getReset']);

			Route::group([
				'prefix' => 'users',
			], function() {
				// Login Routes...
				Route::get('login', ['as' => 'login', 'uses' => 'UsersController@login']);
				Route::post('login', ['as' => 'login.post', 'uses' => 'UsersController@postLogin']);
				Route::get('2fa/choose', ['as' => '2fa.choose', 'uses' => 'UsersController@twoFaChoose']);
				Route::get('2fa/phone', ['as' => '2fa.phone', 'uses' => 'UsersController@twoFaPhone']);
				Route::get('2fa/email', ['as' => '2fa.email', 'uses' => 'UsersController@twoFaEmail']);
				Route::post('2fa/choose', ['as' => '2fa.choose.post', 'uses' => 'UsersController@postTwoFaChoose']);
				Route::post('2fa/email', ['as' => '2fa.email.post', 'uses' => 'UsersController@postTwoFaEmail']);
				Route::post('2fa/phone', ['as' => '2fa.phone.post', 'uses' => 'UsersController@postTwoFaPhone']);

				// Registration Routes...
				Route::get('register', ['as' => 'register', 'uses' => 'UsersController@register']);
				Route::post('register', ['as' => 'register.post', 'uses' => 'UsersController@postSignup']);

				// Password Reset Routes...
				Route::get('password/reset', ['as' => 'password.reset', 'uses' => 'Auth\ResetPasswordController@getEmail']);
				Route::post('password/email', ['as' => 'password.email', 'uses' => 'Auth\ResetPasswordController@postEmail']);
				Route::post('password/reset', ['as' => 'password.reset.post', 'uses' => 'Auth\ResetPasswordController@postReset']);	
			});
		});
		
		// sicialite login
		Route::get('users/login/facebook', ['as' => 'login.facebook', 'uses' => 'UsersController@loginFacebook']);
		Route::get('users/login/facebook/callback', ['as' => 'login.facebook.check', 'uses' => 'UsersController@facebookCheck']);
		Route::get('users/login/twitter', ['as' => 'login.twitter', 'uses' => 'UsersController@loginTwitter']);
		Route::get('users/login/twitter/callback', ['as' => 'login.twitter.check', 'uses' => 'UsersController@twitterCheck']);
		Route::get('users/login/google', ['as' => 'login.google', 'uses' => 'UsersController@loginGoogle']);
		Route::get('users/login/google/callback', ['as' => 'login.google.check', 'uses' => 'UsersController@googleCheck']);
	});
			
	// confirm email
	Route::get('confirm/email/{confirmation_code}', ['as' => 'confirm.code', 'uses' => 'UsersController@confirm']);

	Route::group([
		'prefix' => LaravelLocalization::setLocale(),
		'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'maintenance']
	], function(){
		
		if( config('app.installed', false) ){
			Route::group(['middleware' => ['privateSearch']], function(){
				foreach(AziziSearchEngineStarter\Engines::where('turn', true)->select('controller', 'name')->get() as $engine){
					Route::get('/'.$engine->name.'/search', $engine->controller.'@search');
				}
			});
		}
		
//		if(config('plugins')){
//			foreach(config('plugins') as $plugin){
//				foreach($plugin['routes']['public'] as $route){
//					Route::{$route['type']}($route['route'], $route['action']);
//				}
//			}
//		}
		
		Route::group([], function(){
			Route::group([
				'prefix' => 'api',
			], function(){
				Route::get('suggestions', 'autoCompleteController@auto');
				Route::get('gettopwords', 'GeneralController@getTopWords');
				Route::get('register-query', 'GeneralController@registerQuery');
				Route::get('imagesAjax', 'ImagesController@imagesAjax');
				Route::get('videosAjax', 'VideosController@videosAjax');
				Route::get('ads/adsAjax', ['as' => 'ad.ajax', 'uses' => 'AdsController@ajax']);
				Route::get('ads/adsAjaxSimple', ['as' => 'ad.ajax.simple', 'uses' => 'AdsController@ajaxSimple']);
			});
			
			// ads
			Route::get('ads/checkout/{id}', ['as' => 'ads.checkout.id', 'uses' => 'ProccessPayments@checkout']);
			
			// ads
			Route::get('ads/redirect/pagead/aclk', ['as' => 'ad.redirect', 'uses' => 'AdsController@jumpToAdLink']);

			// submit url
            Route::get('submit', ['as' => 'submit.site', 'uses' => 'GeneralController@getSubmitSite']);
            Route::post('submit', ['uses' => 'GeneralController@postSubmitSite']);

			Route::get('suggetions', 'autoCompleteController@suggetions');
			Route::get('advertise', ['as' => 'advertise', 'uses' => 'GeneralController@Advertise']);
			Route::get('premium_keywords', ['as' => 'premium.keywords', 'uses' => 'GeneralController@PremiumKeywords']);
			Route::post('advertise', 'GeneralController@postAdvertise');
			
			Route::get('preferences', ['as' => 'preferences', 'uses' => 'GeneralController@Settings']);
			Route::post('preferences', ['as' => 'preferences.post', 'uses' => 'GeneralController@postSettings']);
			Route::get('advanced_search', ['as' => 'web.advanced', 'uses' => 'GeneralController@AdvancedSearch']);
			Route::post('advanced_search', ['as' => 'web.advanced.post', 'uses' => 'GeneralController@postAdvancedSearch']);
			
			Route::get('/', ['as' => 'home', 'uses' => 'GeneralController@index']);
			Route::get('{type}', 'GeneralController@indexType')->name('engine.home');
		});
		
	});

});