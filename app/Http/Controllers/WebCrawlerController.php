<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use KubAT\PhpSimple\HtmlDomParser;
use App\WebCrawler;

class WebCrawlerController extends Controller
{
	public function index(){
		$news = WebCrawler::All();
		return view('index',compact('news'));
	}

    public function load_data(){
    	$count = WebCrawler::All()->toArray();

    	if(count($count) == 0 ){
			$news = crawl_news();
	    	for($i =0; $i < 30 ; $i++){
	    		$store_news = new WebCrawler();
		    		$store_news->title = $news['titles'][$i];
			     	$store_news->url = $news['urls'][$i];
		    		$store_news->points = $news['Points'][$i];
		    		$store_news->username = $news['UserNames'][$i];
		    		$store_news->total_comments = $news['TotalComments'][$i];
		    		$store_news->time_stamp = $news['CreatedAt'][$i];
	    		$store_news->save();
	    	}

	    	$news = WebCrawler::All();
	    	return json_encode($news);    		
    	}else if(count($count) != 0 && count($count) <= 30){
    		return json_encode('0');
    	}
    }
    public function re_load_data(){
    	WebCrawler::truncate();
    	$news = crawl_news();

    	for($i =0; $i < 30 ; $i++){
    		$store_news = new WebCrawler();
	    		$store_news->title = $news['titles'][$i];
		     	$store_news->url = $news['urls'][$i];
	    		$store_news->points = $news['Points'][$i];
	    		$store_news->username = $news['UserNames'][$i];
	    		$store_news->total_comments = $news['TotalComments'][$i];
	    		$store_news->time_stamp = $news['CreatedAt'][$i];
    		$store_news->save();
    	}

    	$news = WebCrawler::All();
    	return json_encode($news);
    }

    public function delete_news(Request $request){
    	$id = $request->id;
    	WebCrawler::find($id)->delete();
    	return json_encode('1');
    }
}
