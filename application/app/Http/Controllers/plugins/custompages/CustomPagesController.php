<?php

namespace AziziSearchEngineStarter\Http\Controllers\plugins\custompages;

use Illuminate\Http\Request;
use AziziSearchEngineStarter\Http\Controllers\Controller;
use AziziSearchEngineStarter\CustomPages;
use Input, DB;

class CustomPagesController extends Controller
{
    
	private $id = 'custompages';
	
	public function get($slug) {
		$template = config('app.template');
		$page = CustomPages::where('slug', $slug)->first();
		if(!$page) abort(404);
		$settings = $this->getSettings();
		$data = [];
		$data['title'] = $page->title;
		$data['content'] = $page->body;
		return view('plugins.custompages.'.$template.'.pageLayout', array_merge($data, $this->CommonData()));
	}
    
	public function active() {
		$active = config('plugins.'.$this->id.'.active');
		DB::table('engines')->where('name', 'custompages')->update(['turn' => (int) $active]);
		session()->flash('messageType', 'success');
		session()->flash('message', 'All changes have been made.');
		return redirect()->action('admin\PluginsController@installed');
	}
    
	public function post() {
		dd(Input::all());
	}
	
}
