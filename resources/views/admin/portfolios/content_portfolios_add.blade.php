<div class="wrapper container-fluid">
	{!! Form::open(['url'=>route('portfolioAdd'), 'class'=>'form-horizontal','method'=>'POST','enctype'=>'multipart/form-data']) !!}
		<div class="form-group">
			{!! Form::label('name','Название *',['class'=>'col-xs-2 control-label']) !!}
			<div class="col-xs-4">
				{!! Form::text('name',old('name'),['class'=>'form-control','placeholder'=>'Введите название портфолио']) !!}
			</div>
		</div>

		<div class="form-group">
			{!! Form::label('filter','Категория *',['class'=>'col-xs-2 control-label']) !!}
			<div class="col-xs-4">
				{!! Form::text('filter',old('filter'),['class'=>'form-control','placeholder'=>'Введите категорию']) !!}
			</div>
		</div>

		<div class="form-group">
			{!! Form::label('images','Изображение *',['class'=>'col-xs-2 control-label']) !!}
			<div class="col-xs-8">
				{!! Form::file('images', ['class'=>'filestyle','data-buttonText'=>'Выберите изображение','data-buttonName'=>'btn-primary','data-placeholder'=>'Файла нет']) !!}
			</div>
		</div>

		<div class="form-group">
			<div class="col-xs-offset-2 col-xs-10">
				{!! Form::button('Сохранит',['class'=>'btn btn-primary','type'=>'submit']) !!}
			</div>
		</div>

	{!! Form::close() !!}
	
	
</div>