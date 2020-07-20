<?php
use KubAT\PhpSimple\HtmlDomParser;
 
if (!function_exists('crawl_news')) {
    /**
     * Returns a human readable file size
     *
     * @param integer $bytes
     * Bytes contains the size of the bytes to convert
     *
     * @param integer $decimals
     * Number of decimal places to be returned
     *
     * @return string a string in human readable format
     *
     * */
    function crawl_news()
    {
        $ch = curl_init();
        $url = "https://news.ycombinator.com/";
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($ch);
        curl_close($ch);

        $dom = HtmlDomParser::str_get_html($response);
        $page_title = $dom->find('title')[0]->innertext;

        //Titles
        $titles = [];
        foreach ($dom->find('tr.athing > td.title > a') as $title) {
            $titles[] = $title->innertext;
        }

        //Urls
        $urls = [];
        foreach ($dom->find('tr.athing > td.title > a') as $url) {
            $urls[] = $url->href;
        }        

        //Points
        $Points = [];
        foreach ($dom->find('tr > td.subtext > span.score') as $points) {
            $Points[] = $points->innertext;
        }

        //UserNames
        $UserNames = [];
        foreach ($dom->find('tr > td.subtext > a.hnuser') as $users) {
            $UserNames[] = $users->innertext;
        }

        //CreatedAt
        $CreatedAt = [];
        foreach ($dom->find('tr > td.subtext > span.age > a') as $timestamp) {
            $CreatedAt[] = $timestamp->innertext;
        }


        //TotalComments
        $TotalComments = [];
        foreach ($dom->find('tr > td.subtext') as $comments) {
            if($comments->find('a',3)->innertext != 'discuss'){
                $TotalComments[] = str_replace("&nbsp;"," ",$comments->find('a',3)->innertext);
            }else{
                $TotalComments[] = $comments->find('a',3)->innertext;
            }
        }

        $result = array(
                'titles' => $titles,
                'urls' => $urls,
                'Points' => $Points,
                'UserNames' => $UserNames,
                'CreatedAt' => $CreatedAt,
                'TotalComments' => $TotalComments,
                );

        return $result;
    }
}