<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use App\Page;

class PagesAddController extends Controller
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
    				'alias' => 'required|unique:pages|max:255',
    				'text' => 'required',
    			],$messages);
    	
        //Если валидация не прошла то вернём пользователья в пред. стр

    		if ($validator->fails()) 
    		{	
    			return redirect()->route('pagesAdd')->withErrors($validator)->withInput();
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

    			$page = new Page();

    			$page->fill($input);
                
        //Вернём пользователья на главную страницу
    			if ($page->save()) 
    			{
    				return redirect('admin')->with('status','Новая страница успешно добавлена!');
    			}
    		}

    	}


		if (view()->exists('admin.pages.pages_add')) 
		{

			$data = array(

							'title'=>'Новая Страница',	

							);

			return view('admin.pages.pages_add',$data);

		}else
		{
			echo "404";
		}
	}

    
}
