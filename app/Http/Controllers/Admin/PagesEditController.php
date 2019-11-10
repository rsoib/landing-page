<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Page;
use Validator;

class PagesEditController extends Controller
{
    

    public function execute(Page $page,Request $request)
    {   

        

    //Удаление страницы
        if ($request->isMethod('delete')) 
        {
           $page->delete();
           return redirect('admin')->with('status','Страница успешно удалена!');
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
                                                    'alias' => 'required|max:255|unique:pages,alias,'.$input['id'],
                                                    'text' => 'required'
                                                ],$messages);
     //Если валидация не прошла то вернём пользователья в пред. стр

            if ($validator->fails()) 
            {   
                return redirect()
                            ->route('pagesEdit',
                                ['page'=>$input['id']])
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

    //Если всё таки желает изменить то удаляем старую            
            unset($input['old_images']);

    //Обновляем данные
            $page->fill($input);

    //Вернём пользователья на главную страницу
            if ($page->update()) 
            {
                return redirect('admin')->with('status','Страница успешно обновлена!');
            }

        }      


        //Выташим данные из бд по параметру и отдаем шаблону редактирования
    	$old = $page->toArray();

    	if (view()->exists('admin.pages.pages_edit')) {
    		
    		$data = array(
    						'title' => 'Редактирование страницы - '.$old['name'],
    						'data' => $old
    						);

    		return view('admin.pages.pages_edit',$data); 
    	}

    






    }
}
