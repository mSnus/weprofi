{!! Form::open(array('route' => 'route.name', 'method' => 'POST')) !!}
	<ul>
		<li>
			{!! Form::label('title', 'Title:') !!}
			{!! Form::text('title') !!}
		</li>
		<li>
			{!! Form::label('descr', 'Descr:') !!}
			{!! Form::textarea('descr') !!}
		</li>
		<li>
			{!! Form::label('price', 'Price:') !!}
			{!! Form::text('price') !!}
		</li>
		<li>
			{!! Form::label('client', 'Client:') !!}
			{!! Form::text('client') !!}
		</li>
		<li>
			{!! Form::label('master', 'Master:') !!}
			{!! Form::text('master') !!}
		</li>
		<li>
			{!! Form::label('status', 'Status:') !!}
			{!! Form::text('status') !!}
		</li>
		<li>
			{!! Form::label('accepted', 'Accepted:') !!}
			{!! Form::text('accepted') !!}
		</li>
		<li>
			{!! Form::label('finished', 'Finished:') !!}
			{!! Form::text('finished') !!}
		</li>
		<li>
			{!! Form::submit() !!}
		</li>
	</ul>
{!! Form::close() !!}