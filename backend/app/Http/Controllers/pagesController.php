<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\pages;
use Goutte\Client;

class pagesController extends Controller
{
    private $results = array();
    private $temp = array();
    private $obj = array();
    private $accept = false;
    //returns all data
    public function getData()
    {
        //clear database
        DB::table('pages')->truncate();
        $url = 'https://pinboard.in/u:alasdairw?per_page=120';
        $client = new Client();
        $scraper = $client->request('GET', $url);
        $scraper->filter('.display')->each(function ($node){
            //get title
            $this->obj['url'] = $node->filter('.bookmark_title')->attr('href');
            $this->obj['title'] = $node->filter('.bookmark_title')->text();
            $this->obj['description'] = $node->filter('.description')->text();

            //get tags
            $node->filter('.tag')->each(function ($items) {
                if($items->text() == 'laravel' || $items->text() == 'vue' || $items->text() == 'php' || $items->text() == 'api')
                {
                    $this->accept = true;
                }
                $this->temp[] = $items->text();
            });
            $this->obj['tags'] = $this->temp;
            $this->temp = [];
            if($this->accept){
                $this->results[] = $this->obj;
            }
        });
        //add all results to database
        for($i=0; $i < count($this->results); $i++) {
            $_tags = implode(',', $this->results[$i]['tags']);
            DB::insert('insert into pages (url, name, tags, comments) values (?, ?, ?, ?)', [ $this->results[$i]['url'], $this->results[$i]['title'],$_tags,$this->results[$i]['description'] ]);
        };
        return response()->json($this->results);
    }

    public function returnData()
    {
        return response()->json(DB::table('pages')->get()->all());
    }
}