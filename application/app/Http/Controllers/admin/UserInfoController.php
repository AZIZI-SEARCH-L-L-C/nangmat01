<?php

namespace AziziSearchEngineStarter\Http\Controllers\admin;

use AziziSearchEngineStarter\Http\Controllers\admin\Controller;
use AziziSearchEngineStarter\User;
use Input, Session, Hash;

class UserInfoController extends Controller
{
    
	public function get(){
		$data1 = $this->CommonData();
		$users = User::paginate(50);
		$data2 = [
		    'users' => $users,
		];
		
		$data = array_merge($data1, $data2);
		return view('admin.users.all', $data);
	}

	public function getUser($id){
		$data1 = $this->CommonData();
		$user = User::find($id);
        $payments = $user->payments()->orderBy('created_at', 'desc')->take(5)->get();
        $campaigns = $user->compains()->take(5)->get();
        $comments = $user->comments()->take(5)->get();
        $bookmarks = $user->bookmarks()->take(5)->get();
		$data2 = [
		    'user' => $user,
		    'payments' => $payments,
		    'campaigns' => $campaigns,
		    'comments' => $comments,
		    'bookmarks' => $bookmarks,
		];

		$data = array_merge($data1, $data2);
		return view('admin.users.one', $data);
	}

	public function getCampaigns($id){
	    $user = User::find($id);
        $data1 = $this->CommonData();
        $data2 = [
            'compains' 	=> $user->compains()->paginate(10),
        ];

        $data = array_merge($data1, $data2);
		return view('admin.ads.compains', $data);
	}

	public function getComments($id){
	    $user = User::find($id);
        $data1 = $this->CommonData();
        $data2 = [
            'comments' 	=> $user->comments()->paginate(10),
        ];

        $data = array_merge($data1, $data2);
		return view('admin.users.comments', $data);
	}

	public function getBookmarks($id){
	    $user = User::find($id);
        $data1 = $this->CommonData();
        $data2 = [
            'bookmarks' 	=> $user->bookmarks()->paginate(10),
        ];

        $data = array_merge($data1, $data2);
		return view('admin.users.bookmarks', $data);
	}

	public function getPayments($id){
	    $user = User::find($id);
        $data1 = $this->CommonData();
        $data2 = [
            'payments' 	=> $user->payments()->paginate(10),
        ];

        $data = array_merge($data1, $data2);
		return view('admin.users.payments', $data);
	}
	
	public function redirect(){
		return redirect()->action('admin\UserInfoController@get');
	}
	
	public function post(){
		$errors = false;
		$user = User::find(1);
		if(Input::has('password_old')){
			if (!Hash::check(Input::get('password_old'), $user->password)){
				Session::flash('messageType', 'error');
				Session::flash('message', 'your current password not correct.');
				$errors = true;
			}else{
				if(Input::get('password_new') != Input::get('password_new_conf')){
					Session::flash('messageType', 'error');
					Session::flash('message', 'your password confirmation not match.');
					$errors = true;
				}else{
					$user->password = Hash::make(Input::get('password_new'));
				}
			} 
		}
		$user->username = Input::get('username');
		
		$user->save();
		if(!$errors){
		    Session::flash('messageType', 'success');
		    Session::flash('message', 'All changes have been changed.');
	    }
	    return $this->redirect();
		
	}
 	
}