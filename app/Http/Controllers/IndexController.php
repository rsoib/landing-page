<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Page;
use App\Partfolio;
use App\Service;
use App\People;
use DB;
use Mail;

class IndexController extends Controller
{
    //

    public function execute(Request $request)
    {

    	$pages = Page::all();
    	$partfolios = Partfolio::get(array('name','filter','images' ));
    	$services = Service::all();
    	$peoples = People::take(3)->get();

        //get only partfolio category from database 

        $tags = DB::table('partfolios')->distinct()->pluck('filter');

    	$menu = array();

    	foreach ($pages as $page) 
    	{
    		$item = array('title'=>$page->name, 'alias'=>$page->alias);
    		array_push($menu, $item);
    	}



        //menu 

		$item = array('title'=>'Services', 'alias'=>'service');
    	array_push($menu, $item);

    	$item = array('title'=>'Partfolio', 'alias'=>'Portfolio');
    	array_push($menu, $item);

    	$item = array('title'=>'Team', 'alias'=>'team');
    	array_push($menu, $item);

    	$item = array('title'=>'Contact', 'alias'=>'contact');
    	array_push($menu, $item);

    	return view('site.index',array(
    									'menu'=>$menu,
    									'pages'=>$pages,
    									'partfolios'=>$partfolios,
    									'services'=>$services,
    									'peoples'=>$peoples,
                                        'tags'=>$tags,

    									))->withTitle('Главная страница');
    }

    public function index(Request $request)
    {
         if ($request->isMethod('post')) 
        {
            $messages = 
            [
                'required' => 'Поле :attribute обязательно к запольнению!',
                'email' => 'Напишите правильный :attribute адрес'
            ];

            $this->validate($request,
                [
                    'name' => 'required|max:255',
                    'email' => 'required|email',
                    'text' => 'required',
                ], $messages);

            $data = $request->all();
             
            $result = Mail::send('site.email',['data'=>$data], function($message) use ($data) 
            {
                $mail_admin = env('MAIL_USERNAME');

                $message->from($mail_admin,$data['name']);
                $message->to('rsoib1996@gmail.com')->subject('Message from Landing page');

            }); 

            return redirect()->route('homes')->with('status','Email is send!');
        }

        
    }


}
