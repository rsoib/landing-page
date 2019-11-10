<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Partfolio;
use Validator;

class PortfolioAddController extends Controller
{
    //

    public function execute(Request $request)
    {

    	if ($request->isMethod('post')) 
    	{	
    		$messages = array(

    						'required'=>'Поле :attribute обязательно к запольнению',
    						'unique'=>'Поле :attribute дольжен быть уникальным',
    						'max'=>'Максимальное число символов поле :attribute 255'

    						);

    	//Получаем данные из поле формы кроме поле _token

    		$input = $request->except('_token');

        //Напишем необходимые правила валидации 

    		$validator = Validator::make($input,
    			[
    				'name' => 'required|max:255',
    				'filter' => 'required|max:255',
    			],$messages);

    	//Если валидация не прошла то вернём пользователья в пред. стр

    		if ($validator->fails()) 
    		{	
    			return redirect()->route('portfolioAdd')->withErrors($validator)->withInput();
    		}

    	//Есди валидация прошла то загружаем файла

    		else
    		{
    			if ($request->hasFile('images')) 
    			{
    				$file = $request->file('images');

    				$input['images'] = $file->getClientOriginalName();

    				$file->move(public_path().'/assets/img/',$input['images']);
    			}else
                {
                    $input['images'] = "";
                }
        
        //Записываем данные в базу данных

    			$portfolio = new Partfolio();

    			$portfolio->fill($input);
                
        //Вернём пользователья на главную страницу
    			if ($portfolio->save()) 
    			{
    				return redirect('admin')->with('status','Новое портфолио успешно добавлено!');
    			}

    		}

    	}

   		if (view()->exists('admin.portfolios.portfolios_add')) 
		{

			$data = array(

							'title'=>'Новое портфолио',	

							);

			return view('admin.portfolios.portfolios_add',$data);

		}

    }
}
