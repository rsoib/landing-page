<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Partfolio;

class PortfolioController extends Controller
{
    //

    public function execute()
    {	
    	$portfolios = Partfolio::orderBy('id','desc')->get();
    	$i = 1;

    	$data = array(
						'title' => 'Портфолио',
						'portfolios' => $portfolios,
						'i'=>$i
    					);

    	if (view()->exists('admin.portfolios.portfolios')) 
    	{
    		return view('admin.portfolios.portfolios',$data);
    	}
    }
}
