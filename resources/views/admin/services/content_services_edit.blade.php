<div class="wrapper container-fluid">
	{!! Form::open(['url'=>route('serviceEdit',array('service'=>$data['id'])), 'class'=>'form-horizontal','method'=>'POST','enctype'=>'multipart/form-data']) !!}
		<div class="form-group">
			{!! Form::hidden('id',$data['id'])!!}
			{!! Form::label('name','Название *',['class'=>'col-xs-2 control-label']) !!}
			<div class="col-xs-4">
				{!! Form::text('name',$data['name'],['class'=>'form-control','placeholder'=>'Введите название сервиса']) !!}
			</div>
		</div>

		<div class="form-group">
			{!! Form::label('icon','Иконка *',['class'=>'col-xs-2 control-label']) !!}
			<div class="col-xs-4">
				{!! Form::text('icon',$data['icon'],['class'=>'form-control','placeholder'=>'Введите класс иконку(например: fa-android)']) !!}
			</div>
		</div>

		<div class="form-group">
			{!! Form::label('text','Текст *',['class'=>'col-xs-2 control-label']) !!}
			<div class="col-xs-8">
				{!! Form::textarea('text',$data['text'],['id'=>'editor','class'=>'form-control','placeholder'=>'Введите текст сервиса']) !!}
			</div>
		</div>


		<div class="form-group">
			<div class="col-xs-offset-2 col-xs-10">
				{!! Form::button('Сохранить',['class'=>'btn btn-primary','type'=>'submit']) !!}
			</div>
		</div>

	{!! Form::close() !!}
	
	<script>
		ClassicEditor
    		.create( document.querySelector( '#editor' ) )
    		.then( editor => {
        console.log( editor );
    						} )
    	.catch( error => {
        console.error( error );
    	} );
	</script>
</div>