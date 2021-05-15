{!! Form::open(array('route' => 'route.name', 'method' => 'POST')) !!}
	<ul>
		<li>
			{!! Form::label('descr', 'Descr:') !!}
			{!! Form::textarea('descr') !!}
		</li>
		<li>
			{!! Form::label('status', 'Status:') !!}
			{!! Form::text('status') !!}
		</li>
		<li>
			{!! Form::label('request', 'Request:') !!}
			{!! Form::text('request') !!}
		</li>
		<li>
			{!! Form::label('type', 'Type:') !!}
			{!! Form::text('type') !!}
		</li>
		<li>
			{!! Form::label('score', 'Score:') !!}
			{!! Form::text('score') !!}
		</li>
		<li>
			{!! Form::label('master', 'Master:') !!}
			{!! Form::text('master') !!}
		</li>
		<li>
			{!! Form::label('client', 'Client:') !!}
			{!! Form::text('client') !!}
		</li>
		<li>
			{!! Form::submit() !!}
		</li>
	</ul>
{!! Form::close() !!}