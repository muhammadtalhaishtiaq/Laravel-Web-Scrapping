<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WebCrawler extends Model
{
	protected $table = 'web_crawler';
    protected $fillable = ['title', 'url', 'points','username','total_comments','time_stamp'];
}






