<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Partfolio;
use Validator;


class PortfolioEditController extends Controller
{
    //

    public function execute(Partfolio $portfolio, Request $request)  
    {


        if ($request->isMethod('delete')) 
        {
           $portfolio->delete();
           return redirect('admin')->with('status','Портфолио успешно удалено!');
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
                                                    'filter' => 'required|max:255|',
                                                ],$messages);
     //Если валидация не прошла то вернём пользователья в пред. стр

            if ($validator->fails()) 
            {   
                return redirect()
                            ->route('portfolioEdit',
                                ['portfolio'=>$input['id']])
                                 ->withErrors($validator);
            }

            //Есди валидация прошла то загружаем файла
            
                if ($request->hasFile('images')) 
                {
                    $file = $request->file('images');
                    $file->move(public_path().'/assets/img/',$file->getClientOriginalName());
                    $input['images'] = $file->getClientOriginalName();
                }else
                {
    //Если пользователь не желает изменить изображения то оставим старую 
                  $input['images'] = $input['old_images']; 
                }

                if ($input['images'] == null) 
                {
                    $input['images'] = "";
                }

    //Если всё таки желает изменить то удаляем старую            
            unset($input['old_images']);

    //Обновляем данные
            $portfolio->fill($input);

    //Вернём пользователья на главную страницу
            if ($portfolio->update()) 
            {
                return redirect('admin')->with('status','Портфолио успешно обновлено!');
            }

        }

    	$old = $portfolio->toArray();
    	if (view()->exists('admin.portfolios.portfolios_edit')) {
    		
    		$data = array(
    						'title' => 'Редактирование портфолио - '.$old['name'],
    						'data' => $old
    						);

    		return view('admin.portfolios.portfolios_edit',$data); 
    	}

    }
}
