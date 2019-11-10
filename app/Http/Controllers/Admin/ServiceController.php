<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Service;

class ServiceController extends Controller
{
    //

    	public function execute()
    	{

    		$services = Service::orderBy('id','desc')->get();
    		$i = 1;
    		

    		$data = array(
    						
    						'title' => 'Услуги',
    						'services' => $services,
    						'i' => $i
    						
    						);

    		if (view()->exists('admin.services.services')) 
    		{
    			return view('admin.services.services',$data);
    		}else
    		{
    			echo "404";
    		}
    	}
}
