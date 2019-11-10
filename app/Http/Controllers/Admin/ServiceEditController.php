<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Service;
use Validator;

class ServiceEditController extends Controller
{
    //

    public function execute(Service $service, Request $request)
    {

    	if ($request->isMethod('delete')) 
        {
           $service->delete();
           return redirect('admin')->with('status','Услуга успешно удалена!');
        }

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
                                                    'icon' => 'required|max:255|',
                                                    'text' => 'required|min:3'
                                                ],$messages);

            if ($validator->fails()) 
            {   
                return redirect()
                            ->route('serviceEdit',
                                ['service'=>$input['id']])
                                 ->withErrors($validator);
            }

            $service->fill($input);

    //Вернём пользователья на главную страницу
            if ($service->update()) 
            {
                return redirect('admin')->with('status','Услуга успешно обновлена!');
            }
    }

		    $old = $service->toArray();	

    	if (view()->exists('admin.services.services_edit')) {
  			
  			$data = 
    			[
    				'title' => 'Редактирование услуги - '.$old['name'],
    				'data' => $old
    			];  		
    		
    		return view('admin.services.services_edit',$data);

    	}
    }
}
