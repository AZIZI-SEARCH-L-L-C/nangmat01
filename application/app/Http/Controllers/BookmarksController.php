<?php

namespace AziziSearchEngineStarter\Http\Controllers;

use AziziSearchEngineStarter\Bookmarks;
use AziziSearchEngineStarter\BookmarksCats;
use Input, Auth;

class BookmarksController extends Controller
{
    //
    protected $bookmarksPerPage = 10;

    public function getBookmarks(){
        $engine = Input::get('e', 1);
        $user = Auth::user();
        $common = $this->CommonData();
        $categories = $user->bookmarksCats()->where('engine_id', $engine)->where('main', 1)->get();
        $bookmarks = $user->bookmarks()->where('engine_id', $engine)->ordered()->paginate($this->bookmarksPerPage);

        $thereIsACat = false;

        $data1 = [
            'categories'  => $categories,
            'bookmarks'   => $bookmarks,
            'thereIsACat' => $thereIsACat,
            'main'        => 0,
            'engineID'    => $engine,
        ];

        $data = array_merge($data1, $common);
        return view('auth.profile.bookmarks', $data);
    }

    public function getBookmarksCats($id){
        $user = Auth::user();
        $category = $user->bookmarksCats()->find($id);
        if(!$category)
            abort(404);
        $engine = $category->engine_id;
        $common = $this->CommonData();
        $categories = $user->bookmarksCats()->where('engine_id', $engine)->where('main_id', $category->id)->get();
        if($category->main){
            $bookmarks = $user->bookmarks()->where('engine_id', $engine)->where('category_id', $category->id)->catOrdered()->paginate($this->bookmarksPerPage);
            $main = 1;
        }else{
            $bookmarks = $user->bookmarks()->where('engine_id', $engine)->where('category_id', $category->id)->subCatOrdered()->paginate($this->bookmarksPerPage);
            $main = 1;
        }

        $thereIsACat = true;

        $data1 = [
            'categories'  => $categories,
            'category'    => $category,
            'bookmarks'   => $bookmarks,
            'main'        => $main,
            'thereIsACat' => $thereIsACat,
            'engineID' => $engine,
        ];

        $data = array_merge($data1, $common);
        return view('auth.profile.bookmarks', $data);
    }

    public function bookmarksOrganize(){
        $user = Auth::user();
        $common = $this->CommonData();

        $type = Input::get('t');
        if(!in_array($type, [1,2,3]))
            $type = 1;

        $engine = Input::get('e');
        if(!in_array($engine, [1,2,3,4]))
            $engine = 1;

//        $bookmarks = $user->bookmarks()->where('category_id', $category->id)->paginate($this->bookmarksPerPage);
        $bookmarks = $user->bookmarks()->where('engine_id', $engine)->ordered()->get();

        $category = null;
        if($type != 1) {
            $category = $user->bookmarksCats()->find(Input::get('c'));
            if (!$category)
                abort(404);

            if($category->main) {
                $bookmarks = $user->bookmarks()->where('engine_id', $engine)->where('category_id', $category->id)->catOrdered()->get();
            }else{
                $bookmarks = $user->bookmarks()->where('engine_id', $engine)->where('category_id', $category->id)->subCatOrdered()->get();
            }
        }

        $data1 = [
            'bookmarks'   => $bookmarks,
            'category'    => $category,
            'type'        => $type,
            'engineID'    => $engine,
        ];

        $data = array_merge($data1, $common);
        return view('auth.profile.bookmarksOrganize', $data);
    }

    public function setBookmarkOrganize(){
        $user = Auth::user();
        $order = json_decode(Input::get('json'), true);
        $category = Input::get('category');
        $type = Input::get('type');
        foreach($order as $key => $catOr){
            $catOrModel = $user->bookmarks()->find($catOr['id']);
            if(!$catOrModel) return response('There is an error', 500);
            if($type == 3)
                $catOrModel->order_sub_cat = $key+1;
            elseif($type==2)
                $catOrModel->order_cat = $key+1;
            else
                $catOrModel->order = $key+1;

            $catOrModel->save();
        }
        return 'Order saved';
    }

    public function bookmark(){
        $user = Auth::user();
        $booked = $user->bookmarks()->where('url', Input::get('url'))->first();
        if($booked){
            $booked->delete();
            return trans('bookmarks.unbooked');
        }
        $booked = new Bookmarks();

        $booked->url = Input::get('url');
        $booked->title = Input::get('title');
        $booked->description = Input::get('description');
        $booked->category_id = 0;
        $booked->user_id = Auth::user()->id;
        $booked->engine_id = Input::get('engine');
        $booked->image = Input::get('image');

        $booked->save();
        return trans('bookmarks.booked');
    }

    public function isbookmarked(){
        $user = Auth::user();
        $booked = $user->bookmarks()->where('url', Input::get('url'))->first();
        if($booked){
            return 1;
        }
        return 0;
    }

    public function removeBookmark(){
        $user = Auth::user();
        $IDs = explode(',', Input::get('id'));
        if(empty($IDs)) return response('An error occured', 500);
        foreach($IDs as $id) {
            $booked = $user->bookmarks()->find($id);
            if ($booked) {
                $booked->delete();
            }
        }
        return 'Bookmarks removed';
    }

    public function moveBookmark(){
        $user = Auth::user();
        $catId = Input::get('cat');
        $category = $user->bookmarksCats()->find($catId);
        if(!$category) return response('An error occured', 500);
        $IDs = explode(',', Input::get('id'));
        if(empty($IDs)) return response('An error occured', 500);
        foreach($IDs as $id) {
            $booked = $user->bookmarks()->find($id);
            $booked->category_id = $category->id;
            $booked->save();
        }
        return 'Bookmarks moved';
    }

    public function newCategory(){
        $user = Auth::user();

        $category = new BookmarksCats();

        $category->name = Input::get('name');
        $category->main = Input::get('main', 1);
        $category->main_id = Input::get('main_id', 0);
        $category->engine_id = Input::get('engine_id', 1);
        $category->user_id = $user->id;

        $category->save();

        return 'new category created!';
    }
}
