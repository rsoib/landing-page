<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Page;

class PagesController extends Controller
{
    
	public function execute()
	{
		if (view()->exists('admin.pages.pages')) 
		{
			$pages = Page::orderBy('id','desc')->get();
			$data = array(

							'title'=>'Страницы',
							'pages'=>$pages,			
							'i'=>1
							);




			return view('admin.pages.pages',$data);

		}else
		{
			echo "404";
		}
	}

}
