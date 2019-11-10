<div style="margin:0px 50px 0px 50px">
	{!! Html::link(route('portfolioAdd'),'Добавит портфолио') !!}
  @if($portfolios)

	<table class="table table-hover table-striped">
		
		<thead>
			<tr>
				<th># п/п</th>
				<th>Имя</th>
				<th>Категория</th>
				<th>Изображения</th>
				<th>Дата создания</th>
				<th>Удалить</th>
			</tr>
		</thead>

		<tbody>
			@foreach($portfolios as $k => $portfolio) 
				<tr>
					<td>{{ $i }}</td>
					<td>{!! Html::link(route('portfolioEdit',['portfolio'=>$portfolio->id]),$portfolio->name,['alt'=>$portfolio->name]) !!}</td>
					<td>{{ $portfolio->filter }}</td>
					<td>{!! Html::image('assets/img/'.$portfolio->images,'', ['width'=>'100px']) !!}</td>
					<td>{{ $portfolio->created_at }}</td>
					<td>
						{!! Form::open(['url'=>route('portfolioEdit',['portfolio'=>$portfolio->id]), 'class'=>'form-horizontal','method'=>'POST']) !!}
						
						{{ method_field('DELETE') }}
						{!! Form::button('Удалить',['class'=>'btn btn-danger','type'=>'submit']) !!}

					
						{!! Form::close() !!}
					</td>
				</tr>
			<?php $i++ ;?>
			@endforeach
		</tbody>	
	</table>
 @endif

</div>