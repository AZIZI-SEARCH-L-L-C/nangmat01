<?php

namespace AziziSearchEngineStarter\Http\Controllers\admin;

use AziziSearchEngineStarter\Bookmarks;
use AziziSearchEngineStarter\Comments;
use AziziSearchEngineStarter\Keywords;
use AziziSearchEngineStarter\Sites;
use AziziSearchEngineStarter\Submited;
use Illuminate\Http\Request;
use AziziSearchEngineStarter\Http\Controllers\admin\Controller;
use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;
use Input, Auth;

class SitesController extends Controller
{

    public function getRankedSites(){
        $sites = Sites::paginate(50);
        $data1 = $this->CommonData();

        // $costFactors = DB::table('ads_primery_keywords')->select('keyword', 'leverage')->whereField(0)->get();

        $data2 = [
            'sites' => $sites,
        ];

        $data = array_merge($data1, $data2);
        return view('admin.sites.ranked', $data);
    }

    public function getWaitingSites(){
        $sites = Submited::paginate(50);
        $data1 = $this->CommonData();

        // $costFactors = DB::table('ads_primery_keywords')->select('keyword', 'leverage')->whereField(0)->get();

        $data2 = [
            'sites' => $sites,
        ];

        $data = array_merge($data1, $data2);
        return view('admin.sites.submited', $data);
    }

    public function approve(){
        $url = Input::get('url');
        $data1 = $this->CommonData();

        $client = new Client();
        $res = $client->request('GET', $url);
        $crawler = new Crawler($res->getBody()->getContents());

        $title = '';
        $description = '';
        if($crawler->filterXPath('//head//title')->count() > 0){
            $title = $crawler->filterXPath('//head//title')->text();
        }
        if($crawler->filterXPath("//meta[@name='description']")->count() > 0){
            $description = $crawler->filterXPath("//meta[@name='description']")->attr('content');
        }

        $data2 = [
            'url' => $url,
            'title' => $title,
            'description' => $description,
        ];

        $data = array_merge($data1, $data2);
        return view('admin.sites.approve', $data);
    }

    public function reject($id){
        $submitted = Submited::find($id);

        if(!$submitted){
            session()->flash('messageType', 'error');
            session()->flash('message', 'There is no site to remove.');
            return redirect()->route('admin.sites.waiting');
        }

        $submitted->delete();

        session()->flash('messageType', 'success');
        session()->flash('message', 'Site rejected.');
        return redirect()->route('admin.sites.waiting');
    }

    public function postApprove(){
        $keywords = explode(',', Input::get('keywords'));
        $url = Input::get('url');
        $pages = Input::get('page');
        $ranks = Input::get('rank');
        $title = Input::get('title');
        $description = Input::get('description');
        $org_words = [];

        foreach($keywords as $word){
            $org_words[$word]['page'] = (int) array_get($pages, $word);
            $org_words[$word]['rank'] = (int) array_get($ranks, $word);
        }

        foreach ($org_words as $keyword => $add_word) {
            $keywordObj = Keywords::where('keyword', $keyword)->first();
            if(!$keywordObj) {
                $keywordObj = new Keywords();
            }

            $keywordObj->keyword = $keyword;
            $keywordObj->user_id = Auth::user()->id;

            $keywordObj->save();


            $site = new Sites();

            $site->title = $title;
            $site->description = $description;
            $site->url = $url;
            $site->Vurl = $url;
            $site->enabled = 1;
            $site->page = $add_word['page'];
            $site->rank = $add_word['rank'];
            $site->keyword_id = $keywordObj->id;
            $site->user_id = Auth::user()->id;

            $site->save();
        }
        $this->sessionMessagePlain('Site ranked', 'success');
        return redirect()->action('admin\SitesController@getRankedSites');
    }

    public function postRankedSites(){
        if(Input::has('submitEditSite')){
            $site = Sites::find(Input::get('id'));

            $site->title = Input::get('title');
            $site->description = Input::get('descripiton');
            $site->url = Input::get('url');
            $site->page = Input::get('page');
            $site->rank = Input::get('rank');
            $site->enabled = (boolean) Input::get('enabled');

            $site->save();
        }

        if(Input::has('submitDeleteSite')){
            $site = Sites::find(Input::get('id'));
            if(!$site){
                session()->flash('messageType', 'error');
                session()->flash('message', 'There is no site to remove.');
                return redirect()->action('admin\SitesController@getRankedSites');
            }

            $site->delete();
        }

        $this->sessionMessagePlain('All changes saved', 'success');
        return redirect()->action('admin\SitesController@getRankedSites');
    }

    public function getComments(){
        $comments = Comments::paginate(50);
        $data1 = $this->CommonData();

        // $costFactors = DB::table('ads_primery_keywords')->select('keyword', 'leverage')->whereField(0)->get();

        $data2 = [
            'comments' => $comments,
        ];

        $data = array_merge($data1, $data2);
        return view('admin.engines.comments', $data);
    }

    public function deleteComment($id){
        $comment = Comments::find($id);

        if(!$comment){
            session()->flash('messageType', 'error');
            session()->flash('message', 'There is no comment to remove.');
            return redirect()->route('admin.sites.comments');
        }

        $comment->delete();

        session()->flash('messageType', 'success');
        session()->flash('message', 'The comment deleted successfully.');
        return redirect()->route('admin.sites.comments');
    }

    public function getBookmarks(){
        $bookmarks = Bookmarks::paginate(50);
        $data1 = $this->CommonData();

        // $costFactors = DB::table('ads_primery_keywords')->select('keyword', 'leverage')->whereField(0)->get();

        $data2 = [
            'bookmarks' => $bookmarks,
        ];

        $data = array_merge($data1, $data2);
        return view('admin.engines.bookmarks', $data);
    }

    public function deleteBookmarks($id){
        $bookmark = Bookmarks::find($id);

        if(!$bookmark){
            session()->flash('messageType', 'error');
            session()->flash('message', 'There is no comment to remove.');
            return redirect()->route('admin.sites.bookmarks');
        }

        $bookmark->delete();

        session()->flash('messageType', 'success');
        session()->flash('message', 'The bookmark deleted successfully.');
        return redirect()->route('admin.sites.bookmarks');
    }

}
