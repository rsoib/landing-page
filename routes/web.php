<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(['web'])->group(function()
{

	//home page
	Route::get('/',['uses'=>'IndexController@execute','as'=>'homes']);
	Route::post('/',['uses'=>'IndexController@index','as'=>'index']);
	//page of content
	Route::get('/page/{alias}',['uses'=>'PageController@execute','as'=>'page']);

	Route::auth();

});

//admin
Route::prefix('admin')->middleware(['auth'])->group(function()
{

	//page of admin home
	Route::get('/',function()
	{
		if (view()->exists('admin.index')) {
    		
			$data = array('title'=>'Панел администратора');
			
    		return view('admin.index',$data);
    	}
	});	

	//admin/pages,  page of admin pages

	Route::prefix('pages')->group(function()
	{
		//admin/pages
		Route::get('/',['uses'=>'Admin\PagesController@execute','as'=>'pages']);	

		//admin/pages/add
		Route::match(['get','post'],'/add',['uses'=>'Admin\PagesAddController@execute','as'=>'pagesAdd']);	

		//admin/edit/2
		Route::match(['get','post','delete'],'/edit/{page}',['uses'=>'Admin\PagesEditController@execute','as'=>'pagesEdit']);	
	});

	/* /admin/portfolios */

	Route::prefix('portfolios')->group(function()
	{

		Route::get('/',['uses'=>'Admin\PortfolioController@execute','as'=>'portfolios']);	


		Route::match(['get','post'],'/add',['uses'=>'Admin\PortfolioAddController@execute','as'=>'portfolioAdd']);	


		Route::match(['get','post','delete'],'/edit/{portfolio}',['uses'=>'Admin\PortfolioEditController@execute','as'=>'portfolioEdit']);	
	});

	/* /admin/services */

	Route::prefix('services')->group(function()
	{

		Route::get('/',['uses'=>'Admin\ServiceController@execute','as'=>'services']);	


		Route::match(['get','post'],'/add',['uses'=>'Admin\ServiceAddController@execute','as'=>'serviceAdd']);	


		Route::match(['get','post','delete'],'/edit/{service}',['uses'=>'Admin\ServiceEditController@execute','as'=>'serviceEdit']);	
	});

	/* /admin/teams */
	Route::prefix('peoples')->group(function()
	{
		Route::get('/',['uses'=>'Admin\PeopleController@execute','as'=>'people']);
		
		Route::match('get','post',['uses'=>'PeopleAddController@execute','as'=>'peopleAdd']);

		Route::match(['get','post','delete'],'/edit/{people}',['uses'=>'PeopleEditController@execute','as'=>'peopleEdit']);

	});
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
