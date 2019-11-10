<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Service;
use Validator;

class ServiceAddController extends Controller
{
    //

    public function execute(Request $request)
    {

    	if ($request->isMethod('post')) 
    	{	
    		$messages = array(

    						'required'=>'Поле :attribute обязательно к запольнению',
    						'max'=>'Максимальное число символов поле :attribute 255'
    						);

    		$input = $request->except('_token');

    		$validator = Validator::make($input,
    			[
    				'name' => 'required|max:255',
    				'icon' => 'required|max:255',
    				'text' => 'required|min:3'
    			],$messages);


    		if ($validator->fails()) 
    		{	
    			return redirect()->route('serviceAdd')->withErrors($validator)->withInput();
    		}else
    		{
    			$service = new Service();

    			$service->fill($input);
                

    			if ($service->save()) 
    			{
    				return redirect('admin')->with('status','Новая услуга успешно добавлена!');
    			}
    		}

    	 }


    	$data = array(

    					'title' => 'Добавления услуги',
    					);

    	if (view()->exists('admin.services.services_add')) {
    		
    		return view('admin.services.services_add',$data);	

    	}
    }
}
