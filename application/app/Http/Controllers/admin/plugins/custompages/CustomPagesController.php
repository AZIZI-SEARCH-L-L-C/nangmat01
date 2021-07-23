<?php

namespace AziziSearchEngineStarter\Http\Controllers\admin\plugins\custompages;

use Illuminate\Http\Request;
use AziziSearchEngineStarter\Http\Controllers\admin\Controller;
use AziziSearchEngineStarter\CustomPages;
use Input, DB;
//use Waavi\Translation\Repositories\LanguageRepository;
//use Waavi\Translation\Repositories\TranslationRepository;

class CustomPagesController extends Controller
{
    
	private $id = 'custompages';

    public function get() {
		$action = Input::get('a', 'all');
		$data = $this->CommonData();
		
		switch ($action){
			case 'all':
				$pages = CustomPages::get();
				$data['pages'] = $pages;
				break;
			case 'edit';
				$slug = Input::get('slug');
				$page = CustomPages::where('slug', $slug)->first();
				if(!$page){
					session()->flash('messageType', 'error');
					session()->flash('message', 'page not found.');
					return redirect()->action('admin\plugins\custompages\CustomPagesController@get');
				}
				$data['page'] = $page;
				break;
			case 'remove';
				$slug = Input::get('slug');
				$page = CustomPages::where('slug', $slug)->first();
				if(!$page){
					session()->flash('messageType', 'error');
					session()->flash('message', 'page not found.');
					return redirect()->action('admin\plugins\custompages\CustomPagesController@get');
				}
				$page->delete();
				session()->flash('messageType', 'success');
				session()->flash('message', 'All changes have been made.');
				return redirect()->action('admin\plugins\custompages\CustomPagesController@get');
				break;
		}
		
		$data['plugInfo'] = config('plugins.'.$this->id);
		$data['action'] = $action;
		
		return view('admin.plugins.custompages.get', $data);
	}
    
	public function active() {
		$active = config('plugins.'.$this->id.'.active');
		DB::table('engines')->where('name', 'custompages')->update(['turn' => (int) $active]);
		session()->flash('messageType', 'success');
		session()->flash('message', 'All changes have been made.');
		return redirect()->action('admin\PluginsController@installed');
	}
    
	public function post() {
        $defaultLocale = config('app.locale');
		if(Input::has('submitEdit')){
			$slug = Input::get('slug');
			$page = CustomPages::where('slug', $slug)->first();
			if(!$page){
				session()->flash('messageType', 'error');
				session()->flash('message', 'there is an error in your request.');
				return redirect()->action('admin\plugins\custompages\CustomPagesController@get');
			}
			$page->title = Input::get('title');
			$page->body = Input::get('body');
			$page->save();
		}elseif(Input::has('submitNew')){
			$slug = str_slug(Input::get('slug'), '-');
			$page = CustomPages::where('slug', $slug)->first();
			if($page){
				session()->flash('messageType', 'error');
				session()->flash('message', 'there is an exsit page with the same slug, please change the slug & re-try again.');
				return redirect()->action('admin\plugins\custompages\CustomPagesController@get', ['a' => 'new']);
			}
			
			$newPage = new CustomPages;
			
			$newPage->slug = $slug;

//            $this->translationRepository->create([
//                'locale' => $defaultLocale,
//                'namespace' => '*',
//                'group' => 'custompages-plugin-'.$slug,
//                'item' => 'title',
//                'text' => Input::get('title'),
//            ]);
//
//            $this->translationRepository->create([
//                'locale' => $defaultLocale,
//                'namespace' => '*',
//                'group' => 'custompages-plugin-'.$slug,
//                'item' => 'body',
//                'text' => Input::get('body'),
//            ]);

            $newPage->title = Input::get('title');
            $newPage->body = Input::get('body');

			$newPage->save();
		}
		
		session()->flash('messageType', 'success');
		session()->flash('message', 'Page created.');
		return redirect()->action('admin\plugins\custompages\CustomPagesController@get');
	}
	
}
